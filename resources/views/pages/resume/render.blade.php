<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $resume->title ?? 'Resume' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Inter:wght@400;500;600;700&family=Sora:wght@600;700&family=Merriweather:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <style>
        body { 
            margin: 0; padding: 0; background: #e5e7eb; 
            display: flex; justify-content: center; align-items: flex-start; 
            min-height: 100vh; font-family: 'Inter', sans-serif;
        }
        
        #loader { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: #ffffff; display: flex; flex-direction: column; 
            justify-content: center; align-items: center; z-index: 9999; 
        }
        .spinner { 
            border: 4px solid #f3f3f3; border-top: 4px solid #10b981; 
            border-radius: 50%; width: 50px; height: 50px; 
            animation: spin 1s linear infinite; margin-bottom: 16px; 
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .cv-sheet { 
            width: 210mm; 
            min-height: 297mm; 
            height: max-content;
            background: #ffffff; 
            color: #000000; 
            position: relative;
        }
        #main-drop { 
            padding: 20mm; 
            min-height: 297mm; 
            height: max-content; 
            position: relative;
        }
    </style>
</head>
<body>

    <div id="loader">
        <div class="spinner"></div>
        <div style="font-weight: 600; color: #374151; font-size: 16px;">Menyiapkan Dokumen PDF Anda...</div>
        <div style="font-size: 13px; color: #6b7280; margin-top: 8px;">Mohon tunggu sebentar.</div>
    </div>

    <div>
        <div class="cv-sheet" id="cv-paper">
            <div id="main-drop"></div>
        </div>
    </div>

    <script>
        let rawSchema = {!! json_encode($resume->layout_schema ?? $resume->template->layout_schema ?? []) !!};
        let rawGlobal = {!! json_encode($resume->global_settings ?? $resume->template->global_settings ?? []) !!};
        
        let schema = [];
        try { schema = typeof rawSchema === 'string' ? JSON.parse(rawSchema) : rawSchema; } catch(e) {}
        if (!Array.isArray(schema)) schema = typeof schema === 'object' && schema !== null ? Object.values(schema) : [];

        let globalSettings = { fontFamily: "'DM Sans', sans-serif" };
        try { globalSettings = typeof rawGlobal === 'string' ? JSON.parse(rawGlobal) : rawGlobal; } catch(e) {}
        if (globalSettings && globalSettings.fontFamily) {
            document.getElementById('cv-paper').style.fontFamily = globalSettings.fontFamily;
        }

        function esc(str) { return String(str||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
        function safeText(val) { return String(val || '').replace(/\n/g, '<br>'); }
        function parseItems(itemsData) {
            let items = [];
            try { items = typeof itemsData === 'string' ? JSON.parse(itemsData) : itemsData; } catch(e) {}
            return Array.isArray(items) ? items : [];
        }

        function renderCanvas() {
            const container = document.getElementById('main-drop');
            container.innerHTML = '';
            schema.forEach(block => container.appendChild(renderLayoutNode(block)));
        }

        function renderLayoutNode(block) {
            const wrapper = document.createElement('div');
            const p = block.props;
            
            if (block.isLayout) {
                wrapper.style.cssText = `margin-top:${p.marginTop||0}px; margin-bottom:${p.marginBottom||0}px;`;
                if (block.layoutType === 'col1') {
                    if (block.children && block.children.length) block.children.forEach(child => wrapper.appendChild(renderLayoutNode(child)));
                } else {
                    const [l, r] = (p.ratio || '50_50').split('_').map(Number);
                    const grid = document.createElement('div'); 
                    grid.style.cssText = `display:grid; grid-template-columns:${l}fr ${r}fr; gap:${p.gap||16}px;`;
                    block.columns.forEach(col => {
                        const colDiv = document.createElement('div');
                        if (col.length) col.forEach(child => colDiv.appendChild(renderLayoutNode(child)));
                        grid.appendChild(colDiv);
                    });
                    wrapper.appendChild(grid);
                }
            } else {
                wrapper.innerHTML = renderElementHTML(block);
            }
            return wrapper;
        }

        function renderElementHTML(block) {
            const p = block.props; 
            const wrap = (inner) => `<div style="margin-top:${p.marginTop||0}px;margin-bottom:${p.marginBottom||0}px;">${inner}</div>`;
            const heading = (t, sz, c, sl, lc, lt='1.5', al='left') => `<div style="margin-bottom:6px; padding-bottom:3px; ${(sl===true||sl==='true')?`border-bottom:${lt}px solid ${lc||'#0d0d0d'};`:''}"><span style="font-size:${sz||12}px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:${c||'#0d0d0d'}; text-align:${al}; display:block;">${esc(t)}</span></div>`;

            switch(block.type) {
                case 'header': {
                    const fw = (p.nameBold===true||p.nameBold==='true') ? '700' : '400';
                    const textHtml = `<div style="text-align:${p.align||'left'}; flex:1;">
                        <div style="font-size:${p.nameSize||28}px; font-weight:${fw}; color:${p.nameColor||'#0d0d0d'}; line-height:1.1; letter-spacing:-0.5px;">${esc(p.name)}</div>
                        <div style="font-size:${p.titleSize||14}px; color:${p.titleColor||'#555'}; margin-top:4px;">${esc(p.title)}</div>
                        </div>`;
                    if(p.showPhoto === true || p.showPhoto === 'true') {
                        const br = p.photoShape==='circle' ? '50%' : '8px'; const s = (p.photoSize||80)+'px';
                        const borderStyle = (p.border===true||p.border==='true') ? `border:2px solid ${p.borderColor||'#000'};` : '';
                        let photoHtml = p.imageUrl && p.imageUrl.trim() !== '' ? 
                            `<div style="width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; flex-shrink:0; box-sizing: border-box; ${borderStyle}"></div>` : 
                            `<div style="width:${s}; height:${s}; border-radius:${br}; background:#e2e8f0; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#94a3b8; box-sizing: border-box; ${borderStyle} overflow:hidden;"><i class="fas fa-camera" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
                        const alignRule = p.photoPos === 'left' ? 'flex-direction:row;' : 'flex-direction:row-reverse;';
                        return wrap(`<div style="display:flex; justify-content:space-between; align-items:center; gap:20px; ${alignRule}">${textHtml}${photoHtml}</div>`);
                    }
                    return wrap(textHtml);
                }
                case 'photo': {
                    const br = p.shape==='circle' ? '50%' : (p.shape==='rounded' ? '10px' : '0');
                    const border = (p.border===true||p.border==='true') ? `border:2px solid ${p.borderColor||'#e4e4e4'};` : '';
                    const s = (p.size||100)+'px';
                    let photoHtml = p.imageUrl && p.imageUrl.trim() !== '' ? 
                        `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; box-sizing: border-box; ${border}"></div>` : 
                        `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background:#d1d5db; ${border} box-sizing: border-box; display:inline-flex; align-items:center; justify-content:center; color:#9ca3af;"><i class="fas fa-user" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
                    return wrap(`<div style="text-align:${p.align||'center'};">${photoHtml}</div>`);
                }
                case 'contact': {
                    const fs = (p.fontSize||11)+'px'; const ic = p.iconColor||'#000000'; const items = [];
                    if (p.phone) items.push(`<i class="fas fa-phone" style="color:${ic}; width:14px;"></i> ${esc(p.phone)}`);
                    if (p.email) items.push(`<i class="fas fa-envelope" style="color:${ic}; width:14px;"></i> ${esc(p.email)}`);
                    if (p.address) items.push(`<i class="fas fa-map-marker-alt" style="color:${ic}; width:14px;"></i> ${esc(p.address)}`);
                    if (p.website) items.push(`<i class="fas fa-globe" style="color:${ic}; width:14px;"></i> ${esc(p.website)}`);
                    if (p.layout === 'horizontal') return wrap(`<div style="display:flex; flex-wrap:wrap; gap:14px; font-size:${fs}; color:#000000; justify-content:${p.align==='center'?'center':(p.align==='right'?'flex-end':'flex-start')};">${items.map(i=>`<span>${i}</span>`).join('')}</div>`);
                    return wrap(`<div style="font-size:${fs}; line-height:2; color:#000000; text-align:${p.align};">${items.map(i=>`<div>${i}</div>`).join('')}</div>`);
                }
                case 'summary':
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}<p style="font-size:${p.textSize||11}px; line-height:1.6; color:#000000; text-align:${p.textAlign||'justify'}; margin:0;">${safeText(p.text)}</p>`);
                
                case 'experience': case 'volunteer': case 'organization': {
                    const items = parseItems(p.items);
                    const rows = items.map(it => `<div style="margin-bottom:10px;"><div style="display:flex; justify-content:space-between; align-items:flex-start;"><div><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.title||it.role)}</div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.company||it.org)}${it.location?' · '+esc(it.location):''}</div></div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555; white-space:nowrap; margin-left:8px;">${esc(it.period)}</div></div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:3px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'education': {
                    const items = parseItems(p.items);
                    const rows = items.map(it => `<div style="margin-bottom:8px;"><div style="display:flex; justify-content:space-between; align-items:flex-start;"><div><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.degree)}</div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.school)}${it.gpa?' · '+esc(it.gpa):''}</div></div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555; white-space:nowrap; margin-left:8px;">${esc(it.period)}</div></div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:2px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'project': {
                    const items = parseItems(p.items);
                    const rows = items.map(it => `<div style="margin-bottom:8px;"><div style="display:flex; justify-content:space-between;"><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.name)} ${it.link?`<span style="color:#16a34a; font-weight:400; font-size:10px;">${esc(it.link)}</span>`:''}</div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555;">${esc(it.period)}</div></div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.tech)}</div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:2px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'certification': case 'award': {
                    const items = parseItems(p.items);
                    const rows = items.map(it => `<div style="display:flex; justify-content:space-between; margin-bottom:4px; font-size:${p.fontSize||11}px; color:#000;"><div><strong>${esc(it.name)}</strong> — ${esc(it.issuer||it.org)}${it.desc?' · '+esc(it.desc):''}${it.link?` <span style="color:#16a34a; font-size:10px;">(${esc(it.link)})</span>`:''}</div><div style="color:#555;">${esc(it.year)}</div></div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'publication': {
                    const items = parseItems(p.items);
                    const rows = items.map(it => `<div style="margin-bottom:6px; font-size:${p.fontSize||11}px; color:#000;"><strong>${esc(it.title)}</strong> — <span style="font-style:italic; color:#333;">${esc(it.publisher)}</span> (${esc(it.year)})${it.link ? `<br><span style="color:#16a34a; font-size:10px;">${esc(it.link)}</span>` : ''}</div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'portfolio': case 'references': {
                    const items = parseItems(p.items);
                    const rows = items.map(it=>`<div style="margin-bottom:8px; font-size:${p.fontSize||11}px; color:#000;"><div style="font-weight:700;">${esc(it.name||it.title)} <span style="color:#16a34a; font-weight:400; font-size:10px;">${esc(it.url||'')}</span></div><div style="color:#333;">${esc(it.title||it.desc||'')}</div>${it.phone?`<div style="color:#333;">${esc(it.phone)} · ${esc(it.email)}</div>`:''}</div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'skills': {
                    const items = parseItems(p.items);
                    let body = p.style === 'grouped' ? items.map(it => `<div style="margin-bottom:4px; font-size:${p.fontSize||11}px; color:#000;"><strong>${esc(it.category)}:</strong> ${esc(it.list)}</div>`).join('') : `<div style="font-size:${p.fontSize||11}px; color:#000000;">${items.map(it=>esc(it.list)).join(', ')}</div>`;
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${body}`);
                }
                case 'languages': {
                    const items = parseItems(p.items);
                    const rows = items.map(it=>`<div style="display:flex; justify-content:space-between; font-size:${p.fontSize||11}px; margin-bottom:3px; color:#000;"><span>${esc(it.lang)}</span><span style="color:#333;">${esc(it.level)}</span></div>`).join('');
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
                }
                case 'interests': {
                    const tags = (p.list||'').split(',').map(s=>s.trim()).filter(Boolean);
                    const body = `<div style="display:flex; flex-wrap:wrap; gap:6px;">${tags.map(t=>`<span style="font-size:${p.fontSize||11}px; background:#f1f5f9; padding:2px 10px; border-radius:20px; color:#000000; border:1px solid #ccc;">${esc(t)}</span>`).join('')}</div>`;
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${body}`);
                }
                case 'social': {
                    const items = [];
                    if (p.linkedin) items.push(`<div><i class="fab fa-linkedin" style="color:#000; width:14px;"></i> ${esc(p.linkedin)}</div>`);
                    if (p.github) items.push(`<div><i class="fab fa-github" style="color:#000; width:14px;"></i> ${esc(p.github)}</div>`);
                    if (p.twitter) items.push(`<div><i class="fab fa-twitter" style="color:#000; width:14px;"></i> ${esc(p.twitter)}</div>`);
                    if (p.instagram) items.push(`<div><i class="fab fa-instagram" style="color:#000; width:14px;"></i> ${esc(p.instagram)}</div>`);
                    return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}<div style="font-size:${p.fontSize||11}px; line-height:2; color:#000000;">${items.join('')}</div>`);
                }
                case 'divider': return wrap(`<hr style="border:none; border-top:${p.thickness||1}px solid ${p.color||'#000000'}; margin:0;">`);
                case 'spacer': return wrap(`<div style="height:${p.height||20}px;"></div>`);
                case 'text_block': {
                    const fw = (p.bold===true||p.bold==='true') ? 'bold' : 'normal';
                    const fi = (p.italic===true||p.italic==='true') ? 'italic' : 'normal';
                    return wrap(`<div style="font-size:${p.fontSize||11}px; color:${p.color||'#000000'}; text-align:${p.align||'left'}; font-weight:${fw}; font-style:${fi}; line-height:1.6;">${safeText(p.text)}</div>`);
                }
                case 'section_title': {
                    const border = (p.showLine===true||p.showLine==='true') ? `border-bottom:${p.lineThickness||'1.5'}px solid ${p.lineColor||'#0d0d0d'};` : '';
                    return wrap(`<div style="padding-bottom:3px; margin-bottom:4px; ${border}"><span style="font-size:${p.fontSize||12}px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:${p.color||'#0d0d0d'}; text-align:${p.align||'left'}; display:block;">${esc(p.text)}</span></div>`);
                }
                default: return '';
            }
        }

        window.onload = function() {
            renderCanvas();
            
            setTimeout(() => {
                const element = document.getElementById('cv-paper');
                
                const opt = {
                    margin:       0,
                    filename:     `{{ $resume->title ?? 'Resume' }}.pdf`,
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, useCORS: true, allowTaint: true },
                    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                html2pdf().set(opt).from(element).save().then(() => {
                    
                    fetch(`{{ route('resume.increment-download', $resume->id) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(() => {
                        document.getElementById('loader').innerHTML = `
                            <div style="text-align:center;">
                                <i class="fas fa-check-circle" style="color:#10b981; font-size:48px; margin-bottom:16px;"></i>
                                <div style="font-weight: 700; color: #111827; font-size: 20px;">Unduhan Selesai!</div>
                                <div style="font-size: 14px; color: #6b7280; margin-top: 8px;">Cek folder Download Anda.<br>Tab ini akan tertutup otomatis.</div>
                            </div>
                        `;
                        
                        setTimeout(() => { window.close(); }, 2000);
                    });
                });
            }, 1000); 
        };
    </script>
</body>
</html>