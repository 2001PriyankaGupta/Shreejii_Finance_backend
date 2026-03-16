<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shreeja Finance - Wallet Settlement Ledger</title>
    <style>
        @page { margin: 80px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; border-bottom: 2px solid #0346cb; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 10px; color: #94a3b8; text-align: center; }
        
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0346cb; text-transform: uppercase; }
        .document-title { font-size: 14px; font-weight: bold; color: #475569; margin-top: 5px; }
        
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 15px; margin-top: 30px; display: table; width: 100%; border-left: 5px solid #0346cb; }
        .summary-item { display: table-cell; width: 33.33%; text-align: center; border-right: 1px solid #e2e8f0; }
        .summary-item:last-child { border-right: none; }
        .summary-label { font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
        .summary-value { font-size: 22px; font-weight: bold; color: #0346cb; margin-top: 5px; }

        .table { width: 100%; border-collapse: collapse; margin-top: 35px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .table th { background: #070B1E; color: #ffffff; font-size: 10px; font-weight: bold; text-align: left; padding: 15px 12px; text-transform: uppercase; letter-spacing: 1px; }
        .table td { padding: 12px; font-size: 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .tx-id { font-size: 8px; font-weight: bold; color: #0346cb; background: #eef2ff; padding: 3px 8px; border-radius: 6px; display: inline-block; margin-top: 5px; text-transform: uppercase; }
        .status-badge { font-size: 8px; font-weight: bold; padding: 4px 8px; border-radius: 6px; text-transform: uppercase; border: 1px solid transparent; }
        .status-completed { background: #f0fdf4; color: #166534; border-color: #dcfce7; }
        .status-failed { background: #fef2f2; color: #991b1b; border-color: #fee2e2; }
        .status-pending { background: #fffbeb; color: #92400e; border-color: #fef3c7; }
        
        .bank-details { font-size: 9px; color: #64748b; line-height: 1.2; margin-top: 4px; }
        .rupee { font-family: 'DejaVu Sans', sans-serif; }
    </style>
</head>
<body>
    <header>
        <span class="company-name">Shreeja Finance</span>
        <span style="float: right;" class="document-title">WALLET SETTLEMENT LEDGER</span>
    </header>

    <footer>
        Shreeja Finance Disbursement Analytics - Generated: {{ now()->format('d M, Y h:i A') }} - Internal Financial Audit Trail
    </footer>

    <main>
        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Total Outflow</div>
                <div class="summary-value"><span class="rupee">&#8377;</span> {{ number_format($transactions->where('status', 'COMPLETED')->sum('amount'), 2) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Settled Count</div>
                <div class="summary-value">{{ $transactions->where('status', 'COMPLETED')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pending Liability</div>
                <div class="summary-value" style="color: #92400e;"><span class="rupee">&#8377;</span> {{ number_format($transactions->where('status', 'PENDING')->sum('amount'), 2) }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 25%;">Beneficiary Identity</th>
                    <th style="width: 30%;">Disbursement Destination</th>
                    <th style="width: 15%;">Amount</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 15%;">Log Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                    <tr>
                        <td>
                            <div style="font-weight: bold; font-size: 11px;">{{ $tx->user->name }}</div>
                            <div class="tx-id">TXN-{{ $tx->id }}</div>
                        </td>
                        <td>
                            @if($tx->user->bank_name)
                                <div style="font-weight: bold; color: #334155;">{{ $tx->user->bank_name }}</div>
                                <div class="bank-details">A/C: {{ $tx->user->account_number }}<br/>IFSC: {{ $tx->user->ifsc_code }}</div>
                            @else
                                <div style="color: #ef4444; font-weight: bold;">MISSING BANK DATA</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 900; color: #0346cb;"><span class="rupee">&#8377;</span> {{ number_format($tx->amount, 2) }}</div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($tx->status ?? 'pending') }}">
                                {{ $tx->status ?? 'PENDING' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: bold;">{{ $tx->created_at->format('d M, Y') }}</div>
                            <div style="font-size: 8px; color: #94a3b8;">{{ $tx->created_at->format('h:i A') }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 50px; border-top: 1px dashed #cbd5e1; padding-top: 25px; font-size: 9px; color: #64748b; text-align: justify; line-height: 1.6;">
            <strong>Financial Disclosure:</strong> This document serves as an official internal ledger for payout disbursements at Shreeja Finance. All entries verified as 'COMPLETED' represent successful capital transfers to the designated beneficiary accounts. This data is subject to reconciliation and should be used exclusively for official financial auditing and node settlement verification.
        </div>
    </main>
</body>
</html>
