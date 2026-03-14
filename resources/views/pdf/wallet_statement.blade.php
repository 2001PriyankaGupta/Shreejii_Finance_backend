<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shreejii Finance - Wallet Statement</title>
    <style>
        @page { margin: 100px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; border-bottom: 2px solid #0346cb; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 10px; color: #94a3b8; text-align: center; }
        
        body { font-family: 'Helvetica', sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0346cb; text-transform: uppercase; }
        .document-title { font-size: 14px; font-weight: bold; color: #475569; margin-top: 5px; }
        
        .info-section { margin-top: 30px; display: table; width: 100%; }
        .info-box { display: table-cell; width: 50%; vertical-align: top; }
        .info-label { font-size: 9px; font-weight: bold; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { font-size: 12px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        
        .balance-container { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; margin-top: 20px; }
        .balance-label { font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .balance-amount { font-size: 32px; font-weight: bold; color: #0346cb; }

        .period { font-size: 11px; color: #64748b; background: #f1f5f9; padding: 5px 12px; border-radius: 20px; display: inline-block; margin-top: 10px; }

        .table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        .table th { background: #070B1E; color: #ffffff; font-size: 10px; font-weight: bold; text-align: left; padding: 10px; text-transform: uppercase; }
        .table td { padding: 10px; font-size: 11px; border-bottom: 1px solid #f1f5f9; }
        
        .type-credit { color: #10b981; font-weight: bold; }
        .type-debit { color: #f43f5e; font-weight: bold; }
        .status-badge { font-size: 8px; padding: 2px 6px; border-radius: 4px; background: #f1f5f9; color: #64748b; font-weight: bold; text-transform: uppercase; }
        
        .rupee { font-family: DejaVu Sans, sans-serif; } /* Safe for Rupee symbol in dompdf */
    </style>
</head>
<body>
    <header>
        <span class="company-name">Shreejii Finance</span>
        <span style="float: right;" class="document-title">DIGITAL LEDGER STATEMENT</span>
    </header>

    <footer>
        Shreejii Finance Terminal Copy - Generated on {{ now()->format('d M, Y h:i A') }} - Page 1 of 1
    </footer>

    <main>
        <div class="info-section">
            <div class="info-box">
                <div class="info-label">Account Holder Details</div>
                <div class="info-value">{{ $user->name }}</div>
                
                <div class="info-label">Node Type</div>
                <div class="info-value">{{ $user->role === 'PARTNER' ? 'OFFICIAL PARTNER' : 'OFFICIAL EMPLOYEE' }}</div>
                
                <div class="info-label">Contact Information</div>
                <div class="info-value">{{ $user->phone }} | {{ $user->email }}</div>
            </div>
            <div class="info-box" style="text-align: right;">
                <div class="info-label">Settlement Bank Details</div>
                <div class="info-value">
                    {{ $user->bank_name ?? $user->employeeDetail->bank_name ?? 'Not Linked' }} <br>
                    A/C: {{ $user->account_number ?? $user->employeeDetail->account_number ?? 'XXXX XXXX XXXX' }} <br>
                    IFSC: {{ $user->ifsc_code ?? $user->employeeDetail->ifsc_code ?? 'N/A' }}
                </div>
                
                <div class="period">
                    Period: {{ $startDate->format('d M, Y') }} — {{ $endDate->format('d M, Y') }}
                </div>
            </div>
        </div>

        <div class="balance-container">
            <div class="balance-label">Net Available Liquidity</div>
            <div class="balance-amount"><span class="rupee">₹</span> {{ number_format($balance, 2) }}</div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Entry Date</th>
                    <th>Node Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Sync Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr>
                        <td>
                            {{ $tx->created_at->format('d M, Y') }}<br>
                            <small style="color: #94a3b8;">{{ $tx->created_at->format('h:i A') }}</small>
                        </td>
                        <td>{{ $tx->description }}</td>
                        <td class="{{ $tx->type === 'CREDIT' ? 'type-credit' : 'type-debit' }}">
                            {{ $tx->type }}
                        </td>
                        <td style="font-weight: bold;">
                            {{ $tx->type === 'CREDIT' ? '+' : '-' }} <span class="rupee">₹</span> {{ number_format($tx->amount, 2) }}
                        </td>
                        <td>
                            <span class="status-badge">{{ $tx->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                            No transaction data recorded for this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 40px; border-top: 1px dashed #cbd5e1; padding-top: 20px; font-size: 9px; color: #64748b;">
            <strong>Declaration:</strong> This is an electronically generated statement for Shreejii Finance. Any discrepancies must be reported to the administrator within 48 hours of transaction sync. 
        </div>
    </main>
</body>
</html>
