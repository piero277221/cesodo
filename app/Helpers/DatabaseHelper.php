<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
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

    /**
     * Aplica filtro de año compatible con cualquier query builder
     * 
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param int $year
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public static function whereYear($query, $column, $year)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return $query->whereRaw("strftime('%Y', {$column}) = ?", [$year]);
        } else {
            return $query->whereYear($column, $year);
        }
    }

    /**
     * Aplica filtro de mes compatible con cualquier query builder
     * 
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param int $month
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public static function whereMonth($query, $column, $month)
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return $query->whereRaw("strftime('%m', {$column}) = ?", [sprintf('%02d', $month)]);
        } else {
            return $query->whereMonth($column, $month);
        }
    }
}