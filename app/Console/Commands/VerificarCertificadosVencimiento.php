<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CertificadoMedico;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class VerificarCertificadosVencimiento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificados:verificar-vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica certificados médicos próximos a vencer (30 días o menos) y registra notificaciones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando certificados médicos próximos a vencer...');

        // Obtener certificados próximos a vencer
        $certificadosProximos = CertificadoMedico::proximosAVencer();

        if ($certificadosProximos->isEmpty()) {
            $this->info('No hay certificados próximos a vencer.');
            return Command::SUCCESS;
        }

        $this->info("Se encontraron {$certificadosProximos->count()} certificados próximos a vencer:");

        $notificacionesEnviadas = 0;

        foreach ($certificadosProximos as $certificado) {
            $diasRestantes = $certificado->diasRestantes();
            $persona = $certificado->persona;

            $this->line("- {$persona->nombre_completo} (DNI: {$certificado->numero_documento}) - Vence en {$diasRestantes} días");

            // Aquí puedes implementar el envío de notificaciones
            // Por ejemplo: enviar email, SMS, notificación push, etc.
            
            // Registrar en log
            Log::info('Certificado médico próximo a vencer', [
                'certificado_id' => $certificado->id,
                'persona' => $persona->nombre_completo,
                'dni' => $certificado->numero_documento,
                'dias_restantes' => $diasRestantes,
                'fecha_expiracion' => $certificado->fecha_expiracion->format('d/m/Y'),
                'celular' => $persona->celular,
                'correo' => $persona->correo,
            ]);

            // Marcar como notificado
            $certificado->update(['notificacion_enviada' => true]);
            $notificacionesEnviadas++;

            // Ejemplo de envío de notificación (descomentar y configurar según necesidad):
            /*
            if ($persona->correo) {
                try {
                    Mail::to($persona->correo)->send(new CertificadoProximoVencer($certificado));
                } catch (\Exception $e) {
                    Log::error('Error al enviar email de certificado: ' . $e->getMessage());
                }
            }
            
            if ($persona->celular) {
                try {
                    // Enviar SMS usando un servicio como Twilio
                    // SMS::send($persona->celular, "Su certificado médico vence en {$diasRestantes} días");
                } catch (\Exception $e) {
                    Log::error('Error al enviar SMS de certificado: ' . $e->getMessage());
                }
            }
            */
        }

        $this->info("\n✓ Proceso completado. Se procesaron {$notificacionesEnviadas} notificaciones.");
        $this->info("Las notificaciones han sido registradas en los logs del sistema.");

        // Verificar certificados ya vencidos
        $certificadosVencidos = CertificadoMedico::vencidos();
        if ($certificadosVencidos->isNotEmpty()) {
            $this->warn("\n⚠ Atención: Hay {$certificadosVencidos->count()} certificados VENCIDOS:");
            foreach ($certificadosVencidos as $certificado) {
                $diasVencido = abs($certificado->diasRestantes());
                $this->warn("  - {$certificado->persona->nombre_completo} (DNI: {$certificado->numero_documento}) - Vencido hace {$diasVencido} días");
            }
        }

        return Command::SUCCESS;
    }
}

