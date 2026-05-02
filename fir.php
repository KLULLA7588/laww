<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FIR Draft</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  background: #1a1a2e;
  font-family: 'Segoe UI', Arial, sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  padding: 30px 12px 60px;
}

/* ── Modal card ── */
.modal {
  background: #1e2130;
  border-radius: 12px;
  width: 100%;
  max-width: 660px;
  padding: 28px 32px 32px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.6);
  position: relative;
}

/* ── Header ── */
.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 6px;
}
.modal-title {
  display: flex;
  align-items: center;
  gap: 10px;
}
.modal-title .icon { font-size: 22px; }
.modal-title h1 {
  font-size: 22px;
  font-weight: 700;
  color: #e8e8e8;
}
.modal-title h1 span { color: #e05a2b; }
.modal-sub {
  font-size: 12px;
  color: #888;
  margin-top: 3px;
}
.close-btn {
  background: #2d3148;
  border: none;
  color: #aaa;
  width: 32px; height: 32px;
  border-radius: 50%;
  font-size: 18px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.15s;
  flex-shrink: 0;
}
.close-btn:hover { background: #3a3f60; color: #fff; }

/* ── Warning box ── */
.warn {
  background: #2a1e10;
  border: 1px solid #5a3010;
  border-radius: 8px;
  padding: 13px 16px;
  font-size: 12.5px;
  color: #c9a070;
  line-height: 1.6;
  margin: 16px 0 22px;
}
.warn b { color: #e8a040; }
.warn .red { color: #e05a2b; font-weight: 700; }
.warn .grn { color: #4caf7d; font-weight: 700; }

/* ── Field grid ── */
.grid2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 16px;
}
.grid1 {
  display: grid;
  grid-template-columns: 1fr;
  gap: 16px;
  margin-bottom: 16px;
}

.field { display: flex; flex-direction: column; gap: 6px; }
.field label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #778;
}
.field input,
.field textarea {
  background: #252840;
  border: 1px solid #35395a;
  border-radius: 6px;
  color: #dde;
  font-size: 13.5px;
  font-family: 'Segoe UI', Arial, sans-serif;
  padding: 11px 14px;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
  width: 100%;
}
.field input::placeholder,
.field textarea::placeholder { color: #556; }
.field input:focus,
.field textarea:focus {
  border-color: #e05a2b;
  background: #2a2e4a;
}
.field textarea { resize: vertical; min-height: 90px; line-height: 1.55; }

/* ── Buttons ── */
.btn-row {
  display: flex;
  gap: 12px;
  margin-top: 26px;
  justify-content: flex-end;
  flex-wrap: wrap;
}
.btn {
  font-family: 'Segoe UI', Arial, sans-serif;
  font-size: 13.5px;
  font-weight: 700;
  padding: 12px 26px;
  border-radius: 7px;
  border: none;
  cursor: pointer;
  transition: all 0.18s;
  letter-spacing: 0.3px;
}
.btn-clear {
  background: transparent;
  color: #aaa;
  border: 1.5px solid #35395a;
}
.btn-clear:hover { background: #252840; color: #ddd; }
.btn-save {
  background: #e05a2b;
  color: #fff;
  box-shadow: 0 4px 16px rgba(224,90,43,0.35);
}
.btn-save:hover { background: #c44d22; box-shadow: 0 4px 20px rgba(224,90,43,0.5); }

/* ── WhatsApp tip ── */
.wa-tip {
  text-align: center;
  font-size: 11.5px;
  color: #556;
  margin-top: 14px;
}
.wa-tip b { color: #25D366; }

@media (max-width: 500px) {
  .modal { padding: 20px 16px 24px; }
  .grid2 { grid-template-columns: 1fr; }
  .btn-row { justify-content: center; }
}
</style>
</head>
<body>

<div class="modal">

  <!-- Header -->
  <div class="modal-header">
    <div class="modal-title">
      <span class="icon">📋</span>
      <div>
        <h1>Draft <span>FIR</span></h1>
        <div class="modal-sub">First Information Report — Under Section 154 Cr.P.C.</div>
      </div>
    </div>
    <button class="close-btn" onclick="clearAll()">✕</button>
  </div>

  <!-- Warning -->
  <div class="warn">
    ⚠️ <b>Important:</b> This is a draft for informational purposes only. To officially file an FIR, visit your nearest
    <span class="red">Police Station</span> or call <span class="red">100 / 112</span>.
    You can also use your state's <span class="grn">e-FIR portal</span>.
  </div>

  <!-- Row 1: Police Station + Date -->
  <div class="grid2">
    <div class="field">
      <label>Police Station</label>
      <input type="text" id="station" placeholder="e.g. Sadashiv Peth PS">
    </div>
    <div class="field">
      <label>Date of Incident</label>
      <input type="text" id="fdate" placeholder="05/02/2026" value="05/02/2026">
    </div>
  </div>

  <!-- Row 2: Complainant + Contact -->
  <div class="grid2">
    <div class="field">
      <label>Complainant Name</label>
      <input type="text" id="comp" placeholder="Your full name">
    </div>
    <div class="field">
      <label>Contact Number</label>
      <input type="tel" id="contact" placeholder="Mobile number">
    </div>
  </div>

  <!-- Row 3: Address full width -->
  <div class="grid1">
    <div class="field">
      <label>Complainant Address</label>
      <input type="text" id="address" placeholder="Your full address">
    </div>
  </div>

  <!-- Row 4: Crime + Section -->
  <div class="grid2">
    <div class="field">
      <label>Crime / Offence</label>
      <input type="text" id="offence" placeholder="e.g. Theft">
    </div>
    <div class="field">
      <label>Applicable Section</label>
      <input type="text" id="section" placeholder="e.g. IPC 379">
    </div>
  </div>

  <!-- Row 5: Accused full width -->
  <div class="grid1">
    <div class="field">
      <label>Accused Person(s) — If Known</label>
      <input type="text" id="accused" placeholder="Name / description of accused">
    </div>
  </div>

  <!-- Row 6: Location full width -->
  <div class="grid1">
    <div class="field">
      <label>Location of Incident</label>
      <input type="text" id="place" placeholder="Where did the incident happen?">
    </div>
  </div>

  <!-- Row 7: Description -->
  <div class="grid1">
    <div class="field">
      <label>Description of Incident</label>
      <textarea id="desc" placeholder="Describe in detail what happened, when, how and in what sequence..."></textarea>
    </div>
  </div>

  <!-- Row 8: Witnesses + FIR No -->
  <div class="grid2">
    <div class="field">
      <label>Witnesses</label>
      <input type="text" id="witness" placeholder="Names of witnesses, or None">
    </div>
    <div class="field">
      <label>FIR Number</label>
      <input type="text" id="firno" placeholder="___/20__">
    </div>
  </div>

  <!-- Buttons -->
  <div class="btn-row">
    <button class="btn btn-clear" onclick="clearAll()">Clear</button>
    <button class="btn btn-save"  onclick="savePDF()">⬇ Save as PDF</button>
  </div>

  <div class="wa-tip">
    After saving → WhatsApp → 📎 Attachment → <b>Document</b> → Select PDF
  </div>

</div>

<script>
function g(id, fb) {
  const v = (document.getElementById(id)?.value || '').trim();
  return v || (fb !== undefined ? fb : '[Not specified]');
}

function clearAll() {
  ['station','comp','contact','address','offence','section',
   'accused','place','desc','witness','firno'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
  document.getElementById('fdate').value = '05/02/2026';
}

function savePDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ unit: 'mm', format: 'a4' });

  const PW = 210, ml = 20, mr = 190, CW = 170;
  let y = 10;

  // helpers
  const setF = (style, sz, rgb) => {
    doc.setFont('courier', style || 'normal');
    doc.setFontSize(sz || 10);
    doc.setTextColor(...(rgb || [0,0,0]));
  };
  const ctr = (s, yy, sz, style, rgb) => {
    setF(style, sz, rgb);
    doc.text(String(s), PW/2, yy, { align: 'center' });
  };
  const put = (s, x, yy, sz, style, rgb) => {
    setF(style, sz, rgb);
    doc.text(String(s), x, yy);
    return x + doc.getTextWidth(String(s));
  };
  const hl  = (yy, lw, rgb) => {
    doc.setDrawColor(...(rgb || [0,0,0]));
    doc.setLineWidth(lw || 0.3);
    doc.line(ml, yy, mr, yy);
  };
  const TW  = (s, sz, style) => {
    setF(style || 'normal', sz || 10);
    return doc.getTextWidth(String(s));
  };

  // ── values
  const station = g('station');
  const fdate   = g('fdate', '2026-05-02');
  const firno   = g('firno', '___/20__');
  const comp    = g('comp', '[Not provided]');
  const contact = g('contact', '-');
  const address = g('address', '[Not provided]');
  const offence = g('offence');
  const section = g('section');
  const place   = g('place');
  const desc    = (document.getElementById('desc')?.value || '').trim() || '[Not provided]';
  const accused = g('accused', 'Unknown');
  const witness = g('witness', 'None');
  const today   = new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});

  // ── top meta
  setF('normal', 7, [120,120,120]);
  doc.text(today, ml, y);
  ctr('FIR Draft — NyayaKosh', y, 7, 'normal', [120,120,120]);
  y += 5;

  // ── DRAFT title + rules
  ctr('FIRST INFORMATION REPORT  (DRAFT)', y, 12, 'bold', [0,0,0]); y += 3;
  hl(y, 0.7); y += 1;
  hl(y, 0.25); y += 7;

  // ── Republic / Main title
  ctr('REPUBLIC OF INDIA', y, 7.5, 'normal', [100,100,100]); y += 4.5;
  ctr('FIRST INFORMATION REPORT', y, 15, 'bold', [0,0,0]);   y += 5.5;
  ctr('(Under Section 154 Cr.P.C.)', y, 8, 'normal', [100,100,100]); y += 9;

  // ── Police Station | Date
  let x = ml;
  x = put('Police Station: ', x, y, 10, 'bold');
  x = put(station, x, y, 10, 'normal');
  x = put('  |  ', x, y, 10, 'normal', [80,80,80]);
  x = put('Date: ', x, y, 10, 'bold', [0,0,0]);
  put(fdate, x, y, 10, 'normal');
  y += 5;

  // ── FIR No | Time
  x = ml;
  x = put('FIR No.: ', x, y, 10, 'bold');
  x = put(firno, x, y, 10, 'normal');
  x = put('  |  ', x, y, 10, 'normal', [80,80,80]);
  x = put('Time: ', x, y, 10, 'bold', [0,0,0]);
  put('__:__ hrs', x, y, 10, 'normal');
  y += 10;

  // ── 1. Complainant
  x = ml;
  x = put('1. Complainant: ', x, y, 10, 'bold');
  put(comp, x, y, 10, 'normal');
  y += 5;
  x = ml;
  x = put('   Contact: ', x, y, 10, 'normal');
  x = put(contact, x, y, 10, 'normal');
  x = put('  |  ', x, y, 10, 'normal', [80,80,80]);
  x = put('Address: ', x, y, 10, 'bold', [0,0,0]);
  const addrLines = doc.splitTextToSize(address, mr - x);
  setF('normal', 10); doc.text(addrLines[0], x, y);
  y += 10;

  // ── 2. Nature of Offence
  x = ml;
  x = put('2. Nature of Offence: ', x, y, 10, 'bold');
  put(offence, x, y, 10, 'normal');
  y += 5;
  x = ml;
  x = put('   Section: ', x, y, 10, 'normal');
  put(section, x, y, 10, 'normal');
  y += 10;

  // ── 3. Place of Occurrence
  x = ml;
  x = put('3. Place of Occurrence: ', x, y, 10, 'bold');
  put(place, x, y, 10, 'normal');
  y += 10;

  // ── 4. Description
  put('4. Description:', ml, y, 10, 'bold'); y += 5;
  setF('normal', 10);
  const descLines = doc.splitTextToSize(desc, CW);
  descLines.forEach(dl => { doc.text(dl, ml, y); y += 5; });
  y += 3;

  // ── 5. Accused
  x = ml;
  x = put('5. Accused: ', x, y, 10, 'bold');
  put(accused, x, y, 10, 'normal');
  y += 8;

  // ── 6. Witnesses
  x = ml;
  x = put('6. Witnesses: ', x, y, 10, 'bold');
  put(witness, x, y, 10, 'normal');
  y += 10;

  // ── 7. Declaration
  x = ml;
  x = put('7. Declaration: ', x, y, 10, 'bold');
  put('I declare the above information is true and correct to the best of my knowledge.', x, y, 10, 'normal');
  y += 10;

  // ── Signature
  x = ml;
  setF('bold', 10); doc.text('Signature: ', x, y);
  const slw = TW('Signature: ', 10, 'bold');
  doc.setDrawColor(0,0,0); doc.setLineWidth(0.4);
  doc.line(ml + slw, y, ml + slw + 46, y);
  x = ml + 100;
  x = put('Date: ', x, y, 10, 'bold');
  put(fdate, x, y, 10, 'normal');
  y += 6;

  // ── bottom HR + footer
  hl(y, 0.6); y += 4;
  setF('normal', 7.5, [110,110,110]);
  doc.text('Draft for informational purposes only. File officially at nearest Police Station or call 100/112.', ml, y);
  y += 4;
  doc.text('1/1', mr, y, { align: 'right' });

  doc.save('FIR_Draft_NyayaKosh.pdf');
}
</script>
</body>
</html>