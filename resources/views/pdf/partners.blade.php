<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shreeja Finance - Partner Directory</title>
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
        
        .partner-id { font-size: 8px; font-weight: bold; color: #0346cb; background: #eef2ff; padding: 3px 8px; border-radius: 6px; display: inline-block; margin-top: 5px; text-transform: uppercase; }
        .status-badge { font-size: 8px; font-weight: bold; padding: 4px 8px; border-radius: 6px; text-transform: uppercase; border: 1px solid transparent; }
        .status-approved { background: #f0fdf4; color: #166534; border-color: #dcfce7; }
        .status-rejected { background: #fef2f2; color: #991b1b; border-color: #fee2e2; }
        .status-pending { background: #fffbeb; color: #92400e; border-color: #fef3c7; }
        
        .business-node { font-size: 8px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
    <header>
        <span class="company-name">Shreeja Finance</span>
        <span style="float: right;" class="document-title">PARTNER NETWORK DIRECTORY</span>
    </header>

    <footer>
        Shreeja Finance Partner Analytics - Generated: {{ now()->format('d M, Y h:i A') }} - Internal Data Integrity
    </footer>

    <main>
        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Total Partners</div>
                <div class="summary-value">{{ count($partners) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Active Nodes</div>
                <div class="summary-value">{{ $partners->where('status', 'APPROVED')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Registry Date</div>
                <div class="summary-value" style="font-size: 16px;">{{ now()->format('d M, Y') }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 25%;">Partner Identity</th>
                    <th style="width: 25%;">Business / Node Name</th>
                    <th style="width: 15%;">Contact</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 20%;">Registry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $partner)
                    <tr>
                        <td>
                            <div style="font-weight: bold; font-size: 11px;">{{ $partner->name }}</div>
                            <div class="partner-id">PARTNER-{{ $partner->id }}</div>
                        </td>
                        <td>
                            <div style="font-weight: bold; color: #334155;">{{ $partner->employeeDetail->business_name ?? 'N/A' }}</div>
                            <div class="business-node">{{ $partner->employeeDetail->business_type ?? 'Standard Node' }}</div>
                        </td>
                        <td>
                            <div style="font-weight: bold;">{{ $partner->phone }}</div>
                            <div style="font-size: 8px; color: #94a3b8;">{{ $partner->email }}</div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($partner->status ?? 'pending') }}">
                                {{ $partner->status ?? 'PENDING' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: bold;">{{ $partner->created_at ? $partner->created_at->format('d M, Y') : 'N/A' }}</div>
                            <div style="font-size: 8px; color: #94a3b8;">{{ $partner->created_at ? $partner->created_at->format('h:i A') : '' }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 50px; border-top: 1px dashed #cbd5e1; padding-top: 25px; font-size: 9px; color: #64748b; text-align: justify; line-height: 1.6;">
            <strong>Confidentiality Notice:</strong> This Partner Directory contains sensitive business intelligence belonging to Shreeja Finance. Unauthorized distribution, copying, or disclosure of the contents within this report is strictly prohibited and may result in legal consequences. This document serves as an official audit trail for partner onboarding and active node management as of the generation timestamp.
        </div>
    </main>
</body>
</html>
