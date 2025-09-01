<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    public function scopeByProvince($query, $provinceId)
    {
        return $query->whereHas('city', function ($query) use ($provinceId) {
            $query->where('province_id', $provinceId);
        });
    }

    public function scopeByAutonomousCommunity($query, $autonomousCommunityId)
    {
        return $query->whereHas('city', function ($query) use ($autonomousCommunityId) {
            $query->whereHas('province', function ($query) use ($autonomousCommunityId) {
                $query->where('autonomous_community_id', $autonomousCommunityId);
            });
        });
    }

    public function scopeByAutonomousCommunityAndProvince($query, $autonomousCommunityId, $provinceId)
    {
        return $query->whereHas('city', function ($query) use ($provinceId) {
            $query->where('province_id', $provinceId);
        })->whereHas('city.province', function ($query) use ($autonomousCommunityId) {
            $query->where('autonomous_community_id', $autonomousCommunityId);
        });
    }

    public function scopeByAutonomousCommunityAndProvinceAndCity($query, $autonomousCommunityId, $provinceId, $cityId)
    {
        return $query->where('city_id', $cityId)
            ->whereHas('city', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            })->whereHas('city.province', function ($query) use ($autonomousCommunityId) {
                $query->where('autonomous_community_id', $autonomousCommunityId);
            });
    }

    public function scopeByAutonomousCommunityAndProvinceAndCityAndProperty($query, $autonomousCommunityId, $provinceId, $cityId, $propertyId)
    {
        return $query->where('city_id', $cityId)
            ->whereHas('city', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            })->whereHas('city.province', function ($query) use ($autonomousCommunityId) {
                $query->where('autonomous_community_id', $autonomousCommunityId);
            })->whereHas('properties', function ($query) use ($propertyId) {
                $query->where('id', $propertyId);
            });
    }


}
