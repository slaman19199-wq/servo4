<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Servo Motors Control Panel</title>
<style>
body { font-family: Arial; background: #f8f9fb; padding: 20px; }
.container { width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ddd; }
h2 { text-align: center; margin-bottom: 30px; }
.row { display: flex; justify-content: space-between; flex-wrap: wrap; }
.servo { width: 48%; margin-bottom: 20px; }
label { font-weight: bold; }
input[type=range] { width: 100%; }
.buttons { text-align: center; margin-top: 20px; }
button { padding: 10px 20px; border: none; border-radius: 5px; color: white; cursor: pointer; margin: 5px; font-weight: bold; }
.reset { background: orange; }
.save { background: green; }
.submit { background: blue; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
</style>
</head>
<body>

<div class="container">
  <h2>Servo Motors Control Panel</h2>

  <div class="row">
    <div class="servo">
      <label>Servo 1 Angle: <span id="val1">90°</span></label>
      <input type="range" min="0" max="180" value="90" id="servo1">
    </div>
    <div class="servo">
      <label>Servo 2 Angle: <span id="val2">90°</span></label>
      <input type="range" min="0" max="180" value="90" id="servo2">
    </div>
    <div class="servo">
      <label>Servo 3 Angle: <span id="val3">90°</span></label>
      <input type="range" min="0" max="180" value="90" id="servo3">
    </div>
    <div class="servo">
      <label>Servo 4 Angle: <span id="val4">90°</span></label>
      <input type="range" min="0" max="180" value="90" id="servo4">
    </div>
  </div>

  <div class="buttons">
    <button class="reset" onclick="resetServos()">Reset to 90°</button>
    <button class="save" onclick="savePosition()">Save Position</button>
    <button class="submit" onclick="submitToESP()">Submit to ESP</button>
  </div>

  <h3>Saved Positions</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Servo 1</th>
        <th>Servo 2</th>
        <th>Servo 3</th>
        <th>Servo 4</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tableBody"></tbody>
  </table>
</div>

<script>
let servos = [90,90,90,90];

for (let i=1; i<=4; i++) {
  const s = document.getElementById(servo${i});
  s.addEventListener('input', ()=> {
    servos[i-1] = parseInt(s.value);
    document.getElementById(val${i}).textContent = s.value + '°';
  });
}

function resetServos(){
  for (let i=1; i<=4; i++){
    document.getElementById(servo${i}).value = 90;
    document.getElementById(val${i}).textContent = "90°";
    servos[i-1] = 90;
  }
}

async function savePosition(){
  const res = await fetch('save_position.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      s1: servos[0],
      s2: servos[1],
      s3: servos[2],
      s4: servos[3]
    })
  });
  const data = await res.json();
  alert(data.message);
  loadPositions();
}

async function loadPositions(){
  const res = await fetch('get_positions.php');
  const data = await res.json();
  const table = document.getElementById('tableBody');
  table.innerHTML = '';
  data.forEach(row=>{
    table.innerHTML += `
      <tr>
        <td>${row.id}</td>
        <td>${row.s1}</td>
        <td>${row.s2}</td>
        <td>${row.s3}</td>
        <td>${row.s4}</td>
        <td><button onclick="apply(${row.s1},${row.s2},${row.s3},${row.s4})">Apply</button></td>
      </tr>
    `;
  });
}

function apply(s1,s2,s3,s4){
  document.getElementById('servo1').value = s1;
  document.getElementById('servo2').value = s2;
  document.getElementById('servo3').value = s3;
  document.getElementById('servo4').value = s4;
  servos = [s1,s2,s3,s4];
  for(let i=1;i<=4;i++){ document.getElementById(val${i}).textContent = servos[i-1]+'°'; }
}

function submitToESP(){
  const url = prompt("أدخل IP أو رابط ESP:");
  if(!url) return;
  const query = ?s1=${servos[0]}&s2=${servos[1]}&s3=${servos[2]}&s4=${servos[3]};
  fetch(url + '/set' + query)
  .then(()=> alert("تم إرسال القيم إلى ESP"))
  .catch(()=> alert("فشل الاتصال بـ ESP"));
}

loadPositions();
</script>

</body>
</html>