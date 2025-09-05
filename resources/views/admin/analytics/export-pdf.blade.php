<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo doanh thu</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .header p {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .overview-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .overview-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .overview-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .overview-label {
            color: #666;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e9ecef;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .success-rate {
            color: #28a745;
        }
        
        .pending {
            color: #ffc107;
        }
        
        .completed {
            color: #28a745;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BÁO CÁO DOANH THU</h1>
        <p>Thời gian: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Ngày xuất báo cáo: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Tổng quan -->
    <div class="section">
        <div class="section-title">TỔNG QUAN</div>
        <div class="overview-grid">
            <div class="overview-item">
                <div class="overview-value">{{ number_format($overview['total_orders']) }}</div>
                <div class="overview-label">Tổng đơn hàng</div>
            </div>
            <div class="overview-item">
                <div class="overview-value">{{ number_format($overview['total_revenue'], 0, ',', '.') }} ₫</div>
                <div class="overview-label">Tổng doanh thu</div>
            </div>
            <div class="overview-item">
                <div class="overview-value pending">{{ number_format($overview['pending_orders']) }}</div>
                <div class="overview-label">Đơn hàng đang xử lý</div>
            </div>
            <div class="overview-item">
                <div class="overview-value completed">{{ number_format($overview['completed_orders']) }}</div>
                <div class="overview-label">Đơn hàng đã hoàn thành</div>
            </div>
            <div class="overview-item">
                <div class="overview-value success-rate">{{ $overview['success_rate'] }}%</div>
                <div class="overview-label">Tỷ lệ thành công</div>
            </div>
            <div class="overview-item">
                <div class="overview-value">{{ number_format($overview['avg_order_value'], 0, ',', '.') }} ₫</div>
                <div class="overview-label">Giá trị đơn hàng trung bình</div>
            </div>
        </div>
    </div>

    <!-- Doanh thu theo thời gian -->
    <div class="section">
        <div class="section-title">DOANH THU THEO THỜI GIAN</div>
        <table>
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th class="text-center">Số đơn hàng</th>
                    <th class="text-right">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueData['data'] as $item)
                <tr>
                    <td>{{ $item->date ?? $item->month ?? $item->year ?? $item->week }}</td>
                    <td class="text-center">{{ number_format($item->orders) }}</td>
                    <td class="text-right text-bold">{{ number_format($item->revenue, 0, ',', '.') }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Phương thức thanh toán -->
    <div class="section">
        <div class="section-title">PHƯƠNG THỨC THANH TOÁN</div>
        <table>
            <thead>
                <tr>
                    <th>Phương thức</th>
                    <th class="text-center">Số đơn hàng</th>
                    <th class="text-right">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentStats['methods'] as $index => $method)
                <tr>
                    <td>{{ $method }}</td>
                    <td class="text-center">{{ number_format($paymentStats['orders'][$index]) }}</td>
                    <td class="text-right text-bold">{{ number_format($paymentStats['revenue'][$index], 0, ',', '.') }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Trạng thái đơn hàng -->
    <div class="section">
        <div class="section-title">TRẠNG THÁI ĐƠN HÀNG</div>
        <table>
            <thead>
                <tr>
                    <th>Trạng thái</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-center">Tỷ lệ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderStatusStats['statuses'] as $index => $status)
                <tr>
                    <td>{{ $status }}</td>
                    <td class="text-center">{{ number_format($orderStatusStats['counts'][$index]) }}</td>
                    <td class="text-center text-bold">{{ $orderStatusStats['percentages'][$index] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top sản phẩm -->
    <div class="section">
        <div class="section-title">TOP SẢN PHẨM BÁN CHẠY</div>
        <table>
            <thead>
                <tr>
                    <th>Thứ hạng</th>
                    <th>Tên sản phẩm</th>
                    <th class="text-center">Số lượng bán</th>
                    <th class="text-right">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts['names'] as $index => $name)
                <tr>
                    <td class="text-center text-bold">#{{ $index + 1 }}</td>
                    <td>{{ $name }}</td>
                    <td class="text-center">{{ number_format($topProducts['quantities'][$index]) }}</td>
                    <td class="text-right text-bold">{{ number_format($topProducts['revenues'][$index], 0, ',', '.') }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top khách hàng -->
    <div class="section">
        <div class="section-title">TOP KHÁCH HÀNG</div>
        <table>
            <thead>
                <tr>
                    <th>Thứ hạng</th>
                    <th>Tên khách hàng</th>
                    <th class="text-center">Số đơn hàng</th>
                    <th class="text-right">Tổng chi tiêu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCustomers['names'] as $index => $name)
                <tr>
                    <td class="text-center text-bold">#{{ $index + 1 }}</td>
                    <td>{{ $name }}</td>
                    <td class="text-center">{{ number_format($topCustomers['orders'][$index]) }}</td>
                    <td class="text-right text-bold">{{ number_format($topCustomers['spent'][$index], 0, ',', '.') }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Báo cáo được tạo tự động bởi hệ thống Perfume Luxury</p>
        <p>© {{ date('Y') }} Perfume Luxury. Tất cả quyền được bảo lưu.</p>
    </div>
</body>
</html>
