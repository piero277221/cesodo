<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait SQLiteCompatible
{
    /**
     * Agrega filtro de año compatible con SQLite y MySQL
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereYear($query, $column, $year)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return $query->whereRaw("strftime('%Y', {$column}) = ?", [$year]);
        } else {
            return $query->whereYear($column, $year);
        }
    }

    /**
     * Agrega filtro de mes compatible con SQLite y MySQL
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param int $month
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereMonth($query, $column, $month)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return $query->whereRaw("strftime('%m', {$column}) = ?", [sprintf('%02d', $month)]);
        } else {
            return $query->whereMonth($column, $month);
        }
    }

    /**
     * Obtiene expresión SQL para año compatible con SQLite y MySQL
     * 
     * @param string $column
     * @return string
     */
    public static function yearExpression($column)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return "strftime('%Y', {$column})";
        } else {
            return "YEAR({$column})";
        }
    }

    /**
     * Obtiene expresión SQL para mes compatible con SQLite y MySQL
     * 
     * @param string $column
     * @return string
     */
    public static function monthExpression($column)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return "strftime('%m', {$column})";
        } else {
            return "MONTH({$column})";
        }
    }

    /**
     * Obtiene expresión SQL para día compatible con SQLite y MySQL
     * 
     * @param string $column
     * @return string
     */
    public static function dayExpression($column)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return "strftime('%d', {$column})";
        } else {
            return "DAY({$column})";
        }
    }

    /**
     * Obtiene expresión SQL para fecha compatible con SQLite y MySQL
     * 
     * @param string $column
     * @return string
     */
    public static function dateExpression($column)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return "date({$column})";
        } else {
            return "DATE({$column})";
        }
    }
}