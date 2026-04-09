<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $content->personal->name ?? 'CV' }} - ResuMate</title>
    <style>
        /* Standar Ukuran Kertas A4 untuk PDF */
        @page { margin: 1.27cm; }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 11pt;
        }

        /* Header: Nama Besar di Tengah/Kiri */
        .header {
            margin-bottom: 15px;
        }

        .name {
            font-size: 22pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .contact-info {
            font-size: 10pt;
            margin-bottom: 10px;
        }

        .summary {
            font-size: 10pt;
            text-align: justify;
            margin-top: 10px;
        }

        /* Section Styling sesuai Gambar */
        section {
            margin-top: 15px;
        }

        h2 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1.5px solid #000; /* Garis hitam tebal di bawah judul */
            margin-bottom: 8px;
            padding-bottom: 2px;
        }

        .entry {
            margin-bottom: 12px;
        }

        /* Baris pertama: Nama Institusi & Tahun (Kiri-Kanan) */
        .entry-row-1 {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        /* Baris kedua: Jabatan/Gelar (Italic) */
        .entry-row-2 {
            font-style: italic;
            font-size: 10pt;
            margin-bottom: 3px;
        }

        ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        li {
            font-size: 10pt;
            margin-bottom: 2px;
            text-align: justify;
        }

        .skills-group {
            font-size: 10pt;
            margin-bottom: 4px;
        }

        .skills-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="name">{{ $content->personal->name ?? 'NAMA LENGKAP' }}</div>
        <div class="contact-info">
            {{ $content->personal->address ?? 'Kota, Provinsi' }} | 
            {{ $content->personal->phone ?? '08xxxxxxxxxx' }} | 
            {{ $content->personal->email ?? 'email@domain.com' }}
            @if(!empty($content->personal->linkedin))
                | {{ $content->personal->linkedin }}
            @endif
        </div>
        <div class="summary">
            {{ $content->personal->summary ?? 'Tuliskan profil singkat profesional Anda di sini.' }}
        </div>
    </div>

    @if(!empty($content->education))
    <section>
        <h2>PENDIDIKAN</h2>
        @foreach($content->education as $edu)
        <div class="entry">
            <div class="entry-row-1">
                <span>{{ $edu->school }}</span>
                <span>{{ $edu->period }}</span>
            </div>
            <div class="entry-row-2">
                <span>Jurusan: {{ $edu->major }} {{ isset($edu->gpa) ? '| IPK: '.$edu->gpa : '' }}</span>
            </div>
            @if(!empty($edu->description))
            <ul>
                <li>{{ $edu->description }}</li>
            </ul>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    @if(!empty($content->experience))
    <section>
        <h2>PENGALAMAN KERJA</h2>
        @foreach($content->experience as $exp)
        <div class="entry">
            <div class="entry-row-1">
                <span>{{ $exp->company }}</span>
                <span>{{ $exp->period }}</span>
            </div>
            <div class="entry-row-2">
                <span>{{ $exp->role }}</span>
            </div>
            @if(!empty($exp->description))
            <ul>
                {{-- Kita asumsikan deskripsi bisa berupa array untuk bullet points --}}
                @if(is_array($exp->description))
                    @foreach($exp->description as $desc)
                        <li>{{ $desc }}</li>
                    @endforeach
                @else
                    <li>{{ $exp->description }}</li>
                @endif
            </ul>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    @if(!empty($content->skills))
    <section>
        <h2>KEMAMPUAN</h2>
        @foreach($content->skills as $skill)
        <div class="skills-group">
            <span class="skills-label">{{ $skill->category ?? 'Keahlian' }}:</span> 
            {{ $skill->list }}
        </div>
        @endforeach
    </section>
    @endif

    @if(!empty($content->others))
    <section>
        <h2>SERTIFIKASI & HOBI</h2>
        <ul>
            @foreach($content->others as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </section>
    @endif

</body>
</html>