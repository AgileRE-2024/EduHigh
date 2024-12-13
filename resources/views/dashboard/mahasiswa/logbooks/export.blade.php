<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Consultation Logbook</title>
    <style>
        @page {
            margin: 2.5cm;
        }

        body {
            font-family: Times New Roman, serif;
            line-height: 1.6;
            color: #000;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            gap: 2rem;
        }

        .header .logo {
            width: 100px;
            height: auto;
            object-fit: contain;
        }

        .header .institution-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header .institution {
            text-transform: uppercase;
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
        }

        .header .faculty {
            font-size: 14pt;
            margin: 5px 0;
        }

        .header .address {
            font-size: 10pt;
            margin-top: 5px;
        }

        .logo {
            width: 100px;
            margin-bottom: 15px;
        }

        .institution {
            text-transform: uppercase;
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
        }

        .faculty {
            font-size: 14pt;
            margin: 5px 0;
        }

        .address {
            font-size: 10pt;
            margin-top: 5px;
        }

        .document-title {
            text-align: center;
            margin: 40px 0;
        }

        .document-title h1 {
            font-size: 14pt;
            text-transform: uppercase;
            margin: 0;
            padding: 10px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .student-info {
            margin: 30px 0;
        }

        .student-info table {
            width: 100%;
            border: none;
        }

        .student-info td {
            padding: 5px 0;
            border: none;
            vertical-align: top;
        }

        .student-info td:first-child {
            width: 200px;
            font-weight: bold;
        }

        .consultation-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .consultation-table th,
        .consultation-table td {
            border: 1px solid #000;
            padding: 10px;
            font-size: 11pt;
        }

        .consultation-table th {
            background-color: #f8f8f8;
            font-weight: bold;
            text-align: center;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
        }

        .signature-box {
            margin-top: 80px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9pt;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .page-number:before {
            content: "Page " counter(page);
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('assets/images/airlangga.png') }}" alt="Universitas Airlangga" class="logo">
        <div class="institution-info">
            <p class="institution">Universitas Airlangga</p>
            <p class="faculty">Faculty of Science and Technology</p>
            <p class="faculty">Bachelor of Information Systems</p>
            <p class="address">Jl. Airlangga No. 4 - 6, Surabaya, East Java, Indonesia 60286</p>
        </div>
    </div>
    <div class="document-title">
        <h1>Student Consultation Logbook</h1>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td>Student Name</td>
                <td>: {{ $mahasiswa->user->name }}</td>
            </tr>
            <tr>
                <td>Student ID Number</td>
                <td>: {{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Department</td>
                <td>: Bachelor of Information Systems</td>
            </tr>
            <tr>
                <td>Thesis Title</td>
                <td>: {{ $mahasiswa->user->proposal->titles->first()->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>First Supervisor</td>
                <td>:
                    {{ $mahasiswa->superVisions->where('dosen_pembimbing', 'pembimbing_1')->first()->dosen->user->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Second Supervisor</td>
                <td>:
                    {{ $mahasiswa->superVisions->where('dosen_pembimbing', 'pembimbing_2')->first()->dosen->user->name ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    <table class="consultation-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">Date</th>
                <th width="50%">Consultation Notes</th>
                <th width="20%">Supervisor's Signature</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logbooks as $index => $logbook)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="text-align: center">
                        {{ \Carbon\Carbon::parse($logbook->superVision->date)->format('d F Y') }}
                    </td>
                    <td>{{ $logbook->notes }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">No Consultation Records Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="footer">
        <span class="page-number"></span>
    </div>
</body>

</html>
