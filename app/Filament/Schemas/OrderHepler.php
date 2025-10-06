<?php

namespace App\Filament\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class OrderHepler
{
    public static function calculate(Get $get, Set $set, $so_luong = 0, $don_gia = 0, $vat = 0, $chi_tiet_field = '../../chi_tiet', $tong_tien_hang = '../../amount', $tong_tien_vat = '../../vat_amount', $tong_tien_field = '../../total_amount')
    {
        if ($so_luong && $don_gia) {
            $so_luong = floatval(Str::of($so_luong)->replace('.', '')->replace(',', '.')->value);
            $don_gia = floatval(Str::of($don_gia)->replace('.', '')->replace(',', '.')->value);
            $vat = floatval(Str::of($vat)->replace('.', '')->replace(',', '.')->value);

            $thanh_tien = $so_luong * $don_gia;
            $tien_vat = $thanh_tien * $vat / 100;
            $thanh_tien_vat = floatval($thanh_tien + $tien_vat);
            // $set('total_cost', number_format($thanh_tien, 0, ',', '.'));
            $set('total_cost', $thanh_tien, 0, ',', '.');
            $set('vat_price', number_format($tien_vat, 0, ',', '.'));
            $set('amount', number_format($thanh_tien_vat, 0, ',', '.'));
        }
        self::getTotalAmount($get, $set, $chi_tiet_field, $tong_tien_hang, $tong_tien_vat, $tong_tien_field);
    }

    public static function getTotalAmount(Get $get, Set $set, $chi_tiet_field = 'chi_tiet', $amount = 'amount', $vat_amount = 'vat_amount', $total_amount = 'total_amount')
    {
        $tong_tien = collect($get($chi_tiet_field))
            // ->transform(function ($item) {
            //     $item['total_cost'] = floatval(Str::of($item['total_cost'])->replace('.', '')->replace(',', '.')->value);
            //     return $item;
            // })
            ->sum('total_cost');
        $tien_vat = collect($get($chi_tiet_field))->transform(function ($item) {
            $item['vat_price'] = floatval(Str::of($item['vat_price'])->replace('.', '')->replace(',', '.')->value);

            return $item;
        })->sum('vat_price');
        $tong_tien_vat = collect($get($chi_tiet_field))->transform(function ($item) {
            $item['amount'] = floatval(Str::of($item['amount'])->replace('.', '')->replace(',', '.')->value);

            return $item;
        })->sum('amount');

        $set($amount, number_format($tong_tien, 0, ',', '.'));
        $set($vat_amount, number_format($tien_vat, 0, ',', '.'));
        $set($total_amount, number_format($tong_tien_vat, 0, ',', '.'));
    }
}
