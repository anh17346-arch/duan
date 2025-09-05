<?php

namespace App\Helpers;

class CategoryHelper
{
    /**
     * Translate category name based on locale
     */
    public static function translate($categoryName, $locale = null)
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        if ($locale === 'en') {
            $translations = [
                'Nước hoa nam' => 'Male Perfumes',
                'Nước hoa Nam' => 'Male Perfumes',
                'Nước hoa nữ' => 'Female Perfumes',
                'Nước hoa Nữ' => 'Female Perfumes',
                'Unisex' => 'Unisex Perfumes',
                'Nước hoa Unisex' => 'Unisex Perfumes',
                'Hàng mới về' => 'New Arrivals',
                'Nước hoa nam cao cấp' => 'Premium Male Perfumes',
                'Nước hoa nữ cao cấp' => 'Premium Female Perfumes',
                'Nước hoa cao cấp' => 'Luxury Perfumes',
                'Bộ sưu tập độc quyền' => 'Exclusive Collection',
                'Phiên bản giới hạn' => 'Limited Edition',
                'Bán chạy nhất' => 'Best Sellers',
                'Đang thịnh hành' => 'Trending Now',
                'Bộ sưu tập theo mùa' => 'Seasonal Collection',
                'Hương mùa hè tươi mát' => 'Summer Fresh',
                'Hương mùa đông ấm áp' => 'Winter Warm',
                'Hương mùa xuân nở rộ' => 'Spring Bloom',
                'Hương mùa thu phong phú' => 'Autumn Rich',
                'Đang giảm giá' => 'On Sale',
                'Khuyến mãi' => 'Promotion',
                'Giảm giá' => 'Discount',
                'Hàng hot' => 'Hot Items',
                'Bán chạy' => 'Best Selling',
                'Mới nhất' => 'Latest',
                'Phổ biến' => 'Popular',
                'Được yêu thích' => 'Favorites',
                'Cao cấp' => 'Premium',
                'Sang trọng' => 'Luxury',
                'Độc quyền' => 'Exclusive',
                'Giới hạn' => 'Limited',
                'Đặc biệt' => 'Special',
                'Mùa hè' => 'Summer',
                'Mùa đông' => 'Winter',
                'Mùa xuân' => 'Spring',
                'Mùa thu' => 'Autumn',
            ];
            
            return $translations[$categoryName] ?? $categoryName;
        }
        
        return $categoryName;
    }

    /**
     * Get all available category translations
     */
    public static function getTranslations()
    {
        return [
            'vi' => [
                'Nước hoa nam',
                'Nước hoa nữ',
                'Unisex',
                'Hàng mới về',
                'Nước hoa nam cao cấp',
                'Nước hoa nữ cao cấp',
                'Nước hoa cao cấp',
                'Bộ sưu tập độc quyền',
                'Phiên bản giới hạn',
                'Bán chạy nhất',
                'Đang thịnh hành',
                'Bộ sưu tập theo mùa',
                'Hương mùa hè tươi mát',
                'Hương mùa đông ấm áp',
                'Hương mùa xuân nở rộ',
                'Hương mùa thu phong phú',
            ],
            'en' => [
                'Male Perfumes',
                'Female Perfumes',
                'Unisex Perfumes',
                'New Arrivals',
                'Premium Male Perfumes',
                'Premium Female Perfumes',
                'Luxury Perfumes',
                'Exclusive Collection',
                'Limited Edition',
                'Best Sellers',
                'Trending Now',
                'Seasonal Collection',
                'Summer Fresh',
                'Winter Warm',
                'Spring Bloom',
                'Autumn Rich',
            ]
        ];
    }
}
