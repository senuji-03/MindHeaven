$file = 'c:\xampp\htdocs\MindHeaven\public\js\undergrad\appointments.js'
$content = Get-Content $file -Raw
$lines = $content -split "`r`n"

$newBlock = "async function loadTimeSlots() {`r`n" +
"    const counselorId = document.getElementById('appointmentCounselor')?.value;`r`n" +
"    const date        = document.getElementById('appointmentDate')?.value;`r`n" +
"    const timeSel     = document.getElementById('appointmentTime');`r`n" +
"    if (!timeSel) return;`r`n" +
"`r`n" +
"    if (!counselorId || !date) {`r`n" +
"        timeSel.innerHTML = '<option value="""">Select counselor &amp; date first</option>';`r`n" +
"        timeSel.disabled = true;`r`n" +
"        return;`r`n" +
"    }`r`n" +
"`r`n" +
"    timeSel.innerHTML = '<option value="""">Loading slots...</option>';`r`n" +
"    timeSel.disabled  = true;`r`n" +
"`r`n" +
"    try {`r`n" +
"        const url  = " + '`${BASE}/api/appointments/slots?counselor_id=${encodeURIComponent(counselorId)}&date=${encodeURIComponent(date)}`;' + "`r`n" +
"        const res  = await fetch(url, { credentials: 'same-origin' });`r`n" +
"        const data = await res.json();`r`n" +
"        const slots = Array.isArray(data.slots) ? data.slots : [];`r`n" +
"`r`n" +
"        if (!slots.length) {`r`n" +
"            timeSel.innerHTML = '<option value="""">No timeslots set by counselor for this date</option>';`r`n" +
"            timeSel.disabled = true;`r`n" +
"            return;`r`n" +
"        }`r`n" +
"`r`n" +
"        timeSel.innerHTML = '<option value="""">Choose a time slot</option>' +`r`n" +
"            slots.map(s => {`r`n" +
"                const startFmt = formatSlotLabel(s.start_time);`r`n" +
"                const endFmt   = formatSlotLabel(s.end_time);`r`n" +
"                const label    = " + '`${startFmt} \u2013 ${endFmt}`;' + "`r`n" +
"                const isBooked = s.is_booked == 1 || s.is_booked === '1';`r`n" +
"                return " + '`<option value="${s.start_time}"${isBooked ? ' + "' disabled' : ''" + '}>${label}${isBooked ? ' + "' \u2014 \uD83D\uDD12 Booked' : ''" + '}</option>`;' + "`r`n" +
"            }).join('');`r`n" +
"        timeSel.disabled = false;`r`n" +
"    } catch {`r`n" +
"        timeSel.innerHTML = '<option value="""">Failed to load slots. Try again.</option>';`r`n" +
"        timeSel.disabled = false;`r`n" +
"    }`r`n" +
"}"

# Lines are 0-indexed; we replace lines 149-181 (0-indexed) with new block
$before = ($lines[0..148]) -join "`r`n"
$after  = ($lines[182..($lines.Length-1)]) -join "`r`n"
$result = $before + "`r`n" + $newBlock + "`r`n" + $after
[System.IO.File]::WriteAllText($file, $result, [System.Text.Encoding]::UTF8)
Write-Host "Done"
