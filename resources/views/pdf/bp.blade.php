<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blood Pressure Monitor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .hero {
      background: linear-gradient(135deg, #007BFF 0%, #00C6FF 100%);
      color: white;
      padding: 100px 0;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .features .card {
      border: none;
    }

    .features .icon {
      font-size: 3rem;
      color: #007BFF;
      margin-bottom: 15px;
    }
  </style>
  <style>
    @page {
      /* size: A4 portrait; */
      size: A4 landscape;

    }
  </style>
</head>

<body>



  <!-- Guide Sections -->
  <div id="guide" class="container py-5">

    <!-- Categories -->
    <div class="row mb-5 features text-center">
      <div class="col-md-4">
        <div class="card p-4">
          <div class="icon">🩺</div>
          <h5>What Is BP?</h5>
          <p>The pressure of blood against artery walls, shown as systolic/diastolic (mm Hg).</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <div class="icon">📊</div>
          <h5>Normal Ranges</h5>
          <p>Normal: &lt;120/80 • Elevated: 120–129/&lt;80 • Hypertension: ≥130/80</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <div class="icon">⚠️</div>
          <h5>Crisis Warning</h5>
          <p>BP ≥180/120 with symptoms = emergency. Seek immediate care.</p>
        </div>
      </div>
    </div>

    <!-- Detailed Guide Cards -->
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card border-primary">
          <div class="card-header bg-primary text-white">Measurement Tips</div>
          <div class="card-body">
            <ul>
              <li>Rest 5 mins, sit straight, arm at heart level.</li>
              <li>Avoid food, caffeine, exercise 30 mins before.</li>
              <li>Use right cuff size on bare arm.</li>
              <li>Take 2–3 readings; average them both arm and time.</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card border-warning">
          <div class="card-header bg-warning text-dark">Low BP (Hypotension)</div>
          <div class="card-body">
            <ul>
              <li>BP &lt;90/60 mm Hg.</li>
              <li>Symptoms: dizziness, fainting, blurred vision, fatigue.</li>
              <li>Drink fluids, stand up slowly; see a doctor if frequent.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center my-5">
      <a href="#lifestyle" class="btn btn-lg btn-primary">Learn Lifestyle Tips</a>
    </div>

    <!-- Lifestyle Section -->
    <div id="lifestyle" class="row g-4">
      <div class="col-md-12">
        <div class="card border-success">
          <div class="card-header bg-success text-white">Healthy Lifestyle Habits</div>
          <div class="card-body">
            <ul>
              <li>Follow DASH or Mediterranean diet; reduce salt.</li>
              <li>Exercise regularly; maintain healthy weight.</li>
              <li>Limit alcohol, avoid tobacco, manage stress.</li>
              <li>Monitor BP at home; discuss with your doctor.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>