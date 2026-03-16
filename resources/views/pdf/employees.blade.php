<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shreeja Finance - Employee Records</title>
    <style>
        @page { margin: 80px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; border-bottom: 2px solid #0346cb; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 10px; color: #94a3b8; text-align: center; }
        
        body { font-family: 'Helvetica', sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0346cb; text-transform: uppercase; }
        .document-title { font-size: 14px; font-weight: bold; color: #475569; margin-top: 5px; }
        
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; margin-top: 20px; display: table; width: 100%; }
        .summary-item { display: table-cell; width: 33.33%; text-align: center; }
        .summary-label { font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .summary-value { font-size: 18px; font-weight: bold; color: #0346cb; }

        .table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        .table th { background: #070B1E; color: #ffffff; font-size: 10px; font-weight: bold; text-align: left; padding: 12px 10px; text-transform: uppercase; }
        .table td { padding: 12px 10px; font-size: 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .emp-id { font-size: 8px; font-weight: bold; color: #0346cb; background: #eef2ff; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px; }
        .designation-badge { font-size: 8px; font-weight: bold; padding: 2px 6px; border-radius: 4px; background: #f0fdf4; color: #166534; text-transform: uppercase; }
        
        .rupee { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <header>
        <span class="company-name">Shreeja Finance</span>
        <span style="float: right;" class="document-title">OFFICIAL EMPLOYEE REPOSITORY</span>
    </header>

    <footer>
        Shreeja Finance Confidential - Generated on {{ now()->format('d M, Y h:i A') }} - Internal Use Only
    </footer>

    <main>
        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Total Strength</div>
                <div class="summary-value">{{ count($employees) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Active Nodes</div>
                <div class="summary-value">{{ count($employees) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Report Date</div>
                <div class="summary-value" style="font-size: 14px;">{{ now()->format('d M, Y') }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 30%;">Employee Details</th>
                    <th style="width: 30%;">Contact Info</th>
                    <th style="width: 25%;">Designation</th>
                    <th style="width: 15%;">Joining Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>
                            <div style="font-weight: bold; font-size: 11px;">{{ $employee->name }}</div>
                            <div class="emp-id">ID: {{ $employee->employee_id ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div style="color: #475569;">{{ $employee->email }}</div>
                            <div style="color: #94a3b8; margin-top: 2px;">{{ $employee->phone }}</div>
                        </td>
                        <td>
                            <span class="designation-badge">
                                {{ $employee->employeeDetail?->designation ?? 'UNASSIGNED' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: bold;">
                                {{ ($employee->employeeDetail && $employee->employeeDetail->joining_date) ? date('d M, Y', strtotime($employee->employeeDetail->joining_date)) : 'N/A' }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 40px; border-top: 1px dashed #cbd5e1; padding-top: 20px; font-size: 9px; color: #64748b; text-align: justify;">
            <strong>Confidentiality Notice:</strong> This document contains private employee information. Unauthorized distribution or reproduction is strictly prohibited and subject to legal action under Shreeja Finance HR Policy protocols.
        </div>
    </main>
</body>
</html>
