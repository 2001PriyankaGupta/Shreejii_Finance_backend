<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shreeja Finance - Lead Repository</title>
    <style>
        @page { margin: 80px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; border-bottom: 2px solid #0346cb; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 10px; color: #94a3b8; text-align: center; }
        
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0346cb; text-transform: uppercase; }
        .document-title { font-size: 14px; font-weight: bold; color: #475569; margin-top: 5px; }
        
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; margin-top: 20px; display: table; width: 100%; }
        .summary-item { display: table-cell; width: 33.33%; text-align: center; }
        .summary-label { font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .summary-value { font-size: 18px; font-weight: bold; color: #0346cb; }

        .table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        .table th { background: #070B1E; color: #ffffff; font-size: 9px; font-weight: bold; text-align: left; padding: 12px 8px; text-transform: uppercase; }
        .table td { padding: 10px 8px; font-size: 9px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .lead-id { font-size: 8px; font-weight: bold; color: #0346cb; background: #eef2ff; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px; }
        .status-badge { font-size: 8px; font-weight: bold; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; }
        .status-open { background: #eff6ff; color: #1d4ed8; }
        .status-pending { background: #fffbeb; color: #92400e; }
        .status-approved { background: #f0fdf4; color: #166534; }
        .status-rejected { background: #fef2f2; color: #991b1b; }
        
        .agent-role { font-size: 7px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
    </style>
</head>
<body>
    <header>
        <span class="company-name">Shreeja Finance</span>
        <span style="float: right;" class="document-title">LOAN LEAD PIPELINE REPORT</span>
    </header>

    <footer>
        Shreeja Finance Pipeline Log - Generated on {{ now()->format('d M, Y h:i A') }} - Internal Analytics
    </footer>

    <main>
        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Total Leads</div>
                <div class="summary-value">{{ count($leads) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Conversion Cycle</div>
                <div class="summary-value">{{ $leads->where('status', 'APPROVED')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Report Date</div>
                <div class="summary-value" style="font-size: 14px;">{{ now()->format('d M, Y') }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 20%;">Customer</th>
                    <th style="width: 15%;">Contact</th>
                    <th style="width: 15%;">Location</th>
                    <th style="width: 15%;">Agent</th>
                    <th style="width: 15%;">Loan Type</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr>
                        <td>
                            <div style="font-weight: bold;">{{ $lead->customer_name }}</div>
                            <div class="lead-id">ID: #LL-{{ $lead->id }}</div>
                        </td>
                        <td>{{ $lead->mobile_number }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>
                            <div style="font-weight: bold;">{{ $lead->user->name ?? 'System' }}</div>
                            <div class="agent-role">{{ $lead->user->role ?? 'ADMIN' }}</div>
                        </td>
                        <td>
                            <span style="font-weight: bold; color: #475569;">{{ strtoupper($lead->loan_type) }}</span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($lead->status) }}">
                                {{ $lead->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 40px; border-top: 1px dashed #cbd5e1; padding-top: 20px; font-size: 8px; color: #64748b; text-align: justify;">
            <strong>Data Disclosure:</strong> This document contains real-time lead acquisition data for Shreeja Finance. All entries are subject to final verification by the auditing department. Any unauthorized extraction of this data is a breach of organizational security protocols.
        </div>
    </main>
</body>
</html>
