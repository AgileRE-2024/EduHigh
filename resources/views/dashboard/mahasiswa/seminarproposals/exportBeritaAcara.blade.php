<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara Seminar Proposal</title>
    <style>
        @page {
            margin: 2.5cm;
        }

        body {
            font-family: Times New Roman, serif;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .institution {
            text-transform: uppercase;
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
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
            font-size: 14pt;
            font-weight: bold;
            margin: 30px 0;
            text-decoration: underline;
        }

        .content {
            margin: 20px 0;
        }

        .info-section {
            margin: 20px 0;
        }

        .info-item {
            display: grid;
            grid-template-columns: 150px auto;
            margin: 5px 0;
        }

        .table-container {
            width: 50%;
            margin: 30px auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            text-align: left;
            white-space: nowrap;
        }

        .table td.numeric {
            text-align: center;
            font-weight: 500;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
        }

        .table td:last-child {
            white-space: normal;
        }

        .text-center {
            text-align: center;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            font-size: 14pt;
        }

        .notes {
            margin: 20px 0;
            font-size: 11pt;
        }

        .notes ul {
            list-style-type: none;
            padding-left: 0;
        }

        .notes li {
            margin: 5px 0;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            gap: 50px;
        }

        .signature-box {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            margin: 50px 0 10px 0;
            border-bottom: 1px solid #000;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="institution">Universitas Airlangga</p>
        <p class="faculty">Faculty of Science and Technology</p>
        <p class="faculty">Bachelor of Information Systems</p>
        <p class="address">Jl. Airlangga No. 4 - 6, Surabaya, East Java, Indonesia 60286</p>
    </div>

    <h1 class="document-title">BERITA ACARA SEMINAR PROPOSAL</h1>

    <div class="content">
        <div class="info-section">
            <div class="info-item">
                <span>Hari/Tanggal</span>
                <span>: {{ \Carbon\Carbon::parse($proposal->date)->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <div class="info-item">
                <span>Waktu</span>
                <span>: {{ $proposal->time }} WIB</span>
            </div>
            <div class="info-item">
                <span>Nama Mahasiswa</span>
                <span>: {{ $proposal->mahasiswa->user->name }}</span>
            </div>
            <div class="info-item">
                <span>NIM</span>
                <span>: {{ $proposal->mahasiswa->nim }}</span>
            </div>
            <div class="info-item">
                <span>Judul Skripsi</span>
                <span>: {{ $proposal->mahasiswa->user->proposal->titles->first()->name }}</span>
            </div>
            <div class="info-item">
                <span>Pembimbing I</span>
                <span>:
                    {{ $proposal->proposalAssessments->where('type', 'pembimbing_1')->first()->dosen->user->name ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span>Pembimbing II</span>
                <span>:
                    {{ $proposal->proposalAssessments->where('type', 'pembimbing_2')->first()->dosen->user->name ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span>Penguji</span>
                <span>:
                    {{ $proposal->proposalAssessments->where('type', 'penguji')->first()->dosen->user->name ?? '-' }}</span>
            </div>
        </div>

        <div>
            Rekapitulasi nilai ujian Seminar adalah sebagai berikut:
        </div>

        <b>MATERI SKRIPSI</b>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%">No.</th>
                        <th width="60%">Nama Penguji</th>
                        <th width="30%">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $assessments = $proposal->proposalAssessments->sortBy(function ($assessment) {
                            $order = ['pembimbing_1' => 1, 'pembimbing_2' => 2, 'penguji' => 3];
                            return $order[$assessment->type];
                        });
                    @endphp

                    @foreach ($assessments as $index => $assessment)
                        <tr>
                            <td class="numeric">{{ $index + 1 }}</td>
                            <td>{{ $assessment->dosen->user->name }}
                                ({{ ucfirst(str_replace('_', ' ', $assessment->type)) }})
                            </td>
                            <td class="numeric">{{ number_format($assessment->score, 1) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: center;"><strong>Rata-rata</strong></td>
                        <td class="numeric"><strong>{{ number_format($proposal->numeric_grade, 1) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><strong>Nilai Huruf</strong></td>
                        <td class="numeric"><strong>{{ $letterGrade }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="signature-section">
            <!-- Kotak Tanda Tangan Ketua Penguji -->
            <div class="signature-box">
                <p>Ketua Penguji</p>
                <div style="height: 50px;"></div> <!-- Ruang untuk tanda tangan -->
                <div class="signature-line"></div>
                <p>{{ $proposal->proposalAssessments->where('type', 'penguji')->first()->dosen->user->name }}</p>
                <p>NIP. {{ $proposal->proposalAssessments->where('type', 'penguji')->first()->dosen->nip }}</p>
            </div>

            <!-- Kotak Tanda Tangan Ketua Program Studi -->
            <div class="signature-box">
                <p>Ketua Program Studi</p>
                <div style="height: 50px;"></div> <!-- Ruang untuk tanda tangan -->
                <div class="signature-line"></div>
                <p>[Nama Koordinator]</p>
                <p>NIP. [NIP Koordinator]</p>
            </div>
        </div>

        <div class="notes">
            <p><strong>Catatan: Ketentuan Penilaian</strong></p>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nilai Angka</th>
                            <th>Nilai Huruf</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>75,00-100</td>
                            <td>A</td>
                            <td rowspan="5">Memenuhi syarat untuk dijadikan sebagai materi skripsi</td>
                        </tr>
                        <tr>
                            <td>70,00-74,99</td>
                            <td>AB</td>
                        </tr>
                        <tr>
                            <td>65,00-69,99</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>60,00-64,99</td>
                            <td>BC</td>
                        </tr>
                        <tr>
                            <td>55,00-59,99</td>
                            <td>C</td>
                        </tr>
                        <tr>
                            <td>40,00-54,99</td>
                            <td>D</td>
                            <td rowspan="2">Tidak memenuhi syarat untuk dijadikan sebagai materi skripsi dan harus
                                mengulang</td>
                        </tr>
                        <tr>
                            <td>0,00-39,99</td>
                            <td>E</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p>Batas waktu kedaluwarsa usulan penelitian ini adalah 12 bulan, setelah hari seminar proposal skripsi
                diselenggarakan.</p>
        </div>

    </div>
</body>

</html>
