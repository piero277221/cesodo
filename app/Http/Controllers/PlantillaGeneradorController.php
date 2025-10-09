<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\ContratoTemplate;
use ZipArchive;

class PlantillaGeneradorController extends Controller
{
    public function index()
    {
        return view('contratos.plantillas.generador');
    }

    public function generar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Crear el contenido de la plantilla
        $plantillaContent = $this->crearPlantillaWord($request->contenido, $request->titulo, $logoPath);

        // Guardar la plantilla
        $filename = 'plantilla_' . time() . '.docx';
        $filepath = storage_path('app/public/plantillas/' . $filename);

        // Asegurar que el directorio existe
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        file_put_contents($filepath, $plantillaContent);

        return response()->download($filepath, $filename)->deleteFileAfterSend(true);
    }

    private function crearPlantillaWord($contenido, $titulo, $logoPath)
    {
        // Contenido básico de un documento Word (XML)
        $wordContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:body>';

        // Agregar logo si existe
        if ($logoPath) {
            $wordContent .= '
        <w:p>
            <w:pPr>
                <w:jc w:val="center"/>
            </w:pPr>
            <w:r>
                <w:t>[LOGO_EMPRESA]</w:t>
            </w:r>
        </w:p>';
        }

        // Agregar título
        $wordContent .= '
        <w:p>
            <w:pPr>
                <w:jc w:val="center"/>
                <w:rPr>
                    <w:b/>
                    <w:sz w:val="32"/>
                </w:rPr>
            </w:pPr>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:sz w:val="32"/>
                </w:rPr>
                <w:t>' . htmlspecialchars($titulo) . '</w:t>
            </w:r>
        </w:p>';

        // Procesar el contenido y convertir saltos de línea
        $lineas = explode("\n", $contenido);
        foreach ($lineas as $linea) {
            $wordContent .= '
        <w:p>
            <w:r>
                <w:t>' . htmlspecialchars($linea) . '</w:t>
            </w:r>
        </w:p>';
        }

        $wordContent .= '
    </w:body>
</w:document>';

        // Crear estructura ZIP del archivo DOCX
        $zip = new \ZipArchive();
        $tempFile = tempnam(sys_get_temp_dir(), 'word_template');

        if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
            // Agregar archivos requeridos para un DOCX válido
            $zip->addFromString('[Content_Types].xml', $this->getContentTypes());
            $zip->addFromString('_rels/.rels', $this->getRels());
            $zip->addFromString('word/_rels/document.xml.rels', $this->getDocumentRels());
            $zip->addFromString('word/document.xml', $wordContent);
            $zip->addFromString('word/styles.xml', $this->getStyles());
            $zip->close();
        }

        $content = file_get_contents($tempFile);
        unlink($tempFile);

        return $content;
    }

    private function getContentTypes()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
    <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
</Types>';
    }

    private function getRels()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>';
    }

    private function getDocumentRels()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>';
    }

    private function getStyles()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:docDefaults>
        <w:rPrDefault>
            <w:rPr>
                <w:rFonts w:ascii="Calibri" w:eastAsia="Calibri" w:hAnsi="Calibri" w:cs="Calibri"/>
                <w:sz w:val="22"/>
                <w:szCs w:val="22"/>
                <w:lang w:val="es-ES" w:eastAsia="en-US" w:bidi="ar-SA"/>
            </w:rPr>
        </w:rPrDefault>
    </w:docDefaults>
</w:styles>';
    }

    public function plantillaBase()
    {
        $plantillaBase = "CONTRATO DE TRABAJO

Entre la empresa &#123;&#123;empresa&#125;&#125; y el trabajador &#123;&#123;nombre&#125;&#125;, identificado con cédula &#123;&#123;cedula&#125;&#125;, se establece el siguiente acuerdo:

CARGO: &#123;&#123;cargo&#125;&#125;
SALARIO: &#123;&#123;salario&#125;&#125;
FECHA DE INICIO: &#123;&#123;fecha_inicio&#125;&#125;

CLÁUSULAS:

1. OBJETO DEL CONTRATO
El empleado se compromete a prestar sus servicios profesionales en el cargo de &#123;&#123;cargo&#125;&#125; bajo la dirección y dependencia de &#123;&#123;empresa&#125;&#125;.

2. DURACIÓN
Este contrato tiene una duración indefinida, iniciando el &#123;&#123;fecha_inicio&#125;&#125;.

3. SALARIO
El empleado devengará un salario mensual de &#123;&#123;salario&#125;&#125;, que será cancelado los días 30 de cada mes.

4. JORNADA LABORAL
La jornada laboral será de 8 horas diarias, de lunes a viernes.

5. PRESTACIONES SOCIALES
El empleado tendrá derecho a todas las prestaciones sociales establecidas por la ley.

Firman en constancia:

_____________________        _____________________
&#123;&#123;empresa&#125;&#125;                   &#123;&#123;nombre&#125;&#125;
Empleador                     Empleado
C.C. &#123;&#123;cedula&#125;&#125;";

        return response()->json(['plantilla' => $plantillaBase]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string'
        ]);

        try {
            // Limpiar el contenido HTML para guardarlo como plantilla
            $contenido = $request->contenido;

            // Remover los spans con la X de eliminación y mantener solo el texto de los marcadores
            $contenido = preg_replace(
                '/<span class="marcador-tag"[^>]*>(.*?)<button[^>]*>×<\/button><\/span>/',
                '$1',
                $contenido
            );

            // Detectar marcadores en el contenido
            $matches = [];
            preg_match_all('/\{\{([^}]+)\}\}/', $contenido, $matches);
            $marcadores = array_unique($matches[0]);

            // Crear el registro en la base de datos
            $template = ContratoTemplate::create([
                'nombre' => $request->titulo,
                'descripcion' => 'Plantilla creada con el generador visual',
                'contenido' => $contenido,
                'tipo' => 'html',
                'marcadores' => $marcadores,
                'activo' => true,
                'es_predeterminado' => false,
                'creado_por' => Auth::check() ? Auth::id() : 1 // Si no hay usuario autenticado, usar ID 1
            ]);

            // También guardar en archivo como backup
            $plantillaPath = storage_path('app/plantilla_contrato.html');

            // Asegurar que el directorio existe
            if (!file_exists(dirname($plantillaPath))) {
                mkdir(dirname($plantillaPath), 0755, true);
            }

            file_put_contents($plantillaPath, $contenido);

            return response()->json([
                'success' => true,
                'message' => 'Plantilla guardada exitosamente y disponible en el módulo de plantillas',
                'template_id' => $template->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la plantilla: ' . $e->getMessage()
            ], 500);
        }
    }
}
