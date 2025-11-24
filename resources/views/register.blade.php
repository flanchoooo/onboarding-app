<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>NBS Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        :root {
            --nbs-green: #008b3a;
            --nbs-green-dark: #00662b;
            --nbs-green-light: #e5f7ec;
            --nbs-white: #ffffff;
            --nbs-grey: #f4f4f4;
            --nbs-text: #222222;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--nbs-grey);
            color: var(--nbs-text);
        }
        .app-container { min-height: 100vh; display: flex; flex-direction: column; }
        header { background: var(--nbs-green); color: var(--nbs-white); padding: 1rem 1.25rem; text-align: center; }
        header h1 { margin: 0; font-size: 1.4rem; }
        header p { margin: 0.35rem 0 0; font-size: 0.9rem; opacity: 0.9; }
        main { flex: 1; padding: 1.25rem; max-width: 600px; margin: 0 auto; }
        .card { background: var(--nbs-white); border-radius: 0.85rem; padding: 1.25rem; box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.7rem 1rem; border-radius: 999px; font-weight: 600; border: none; cursor: pointer; }
        .btn-primary { background: var(--nbs-green); color: var(--nbs-white); }
        .btn-secondary { background: var(--nbs-green-light); color: var(--nbs-green-dark); }
        .btn-link { color: var(--nbs-green-dark); text-decoration: none; font-weight: 600; }
        .section-title { margin: 0 0 0.5rem; font-size: 1.2rem; font-weight: 700; }
        .section-subtitle { margin: 0 0 1.2rem; font-size: 0.9rem; color: #555; }
        form { display: flex; flex-direction: column; gap: 0.85rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.25rem; }
        label { font-size: 0.9rem; font-weight: 600; color: #333; }
        input[type="text"], input[type="file"], textarea {
            padding: 0.7rem 0.75rem; border-radius: 0.55rem; border: 1px solid #d0d0d0; font-size: 0.95rem; width: 100%;
        }
        textarea { min-height: 70px; resize: vertical; }
        input:focus, textarea:focus { outline: none; border-color: var(--nbs-green); box-shadow: 0 0 0 2px rgba(0,139,58,0.18); }
        .error-message { font-size: 0.8rem; color: #c21b1b; }
        .required { color: #c21b1b; }
        .divider { height: 1px; background: #e5e5e5; margin: 1rem 0; }
        .badge-step { display: inline-flex; align-items: center; gap: 0.4rem; background: var(--nbs-green-light); color: var(--nbs-green-dark); padding: 0.25rem 0.6rem; border-radius: 999px; font-size: 0.78rem; margin-bottom: 0.6rem; }
        .badge-step span.step-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--nbs-green-dark); }
        .text-center { text-align: center; }
        .success-icon { width: 80px; height: 80px; border-radius: 50%; border: 3px solid var(--nbs-green); display: none; align-items: center; justify-content: center; margin: 0 auto 1rem; background: var(--nbs-green-light); }
        .success-icon::before { content: "✓"; font-size: 2.5rem; color: var(--nbs-green-dark); }
        .ref-box { display: none; padding: 0.35rem 0.7rem; border-radius: 999px; background: var(--nbs-green-light); color: var(--nbs-green-dark); font-weight: 600; font-size: 0.86rem; }
        footer { text-align: center; padding: 0.75rem 1rem 1rem; font-size: 0.75rem; color: #666; }
        @media (min-width: 700px) { header h1 { font-size: 1.6rem; } }
    </style>
</head>
<body>
<div class="app-container">
    <header>
        <h1>NBS Mobile Account Opening</h1>
        <p>Complete your registration details below.</p>
    </header>

    <main>
        <div class="card">
            <div class="badge-step"><span class="step-dot"></span> Step 1 of 2 – Enter your details</div>
            <h2 class="section-title">Customer Registration</h2>
            <p class="section-subtitle">Please provide your details as they appear on your National ID.</p>

            <form id="registrationForm" novalidate>
                <div class="form-group">
                    <label for="firstName">Name <span class="required">*</span></label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required />
                    <div class="error-message" data-error-for="firstName"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Surname <span class="required">*</span></label>
                    <input type="text" id="lastName" name="lastName" placeholder="Enter your surname" required />
                    <div class="error-message" data-error-for="lastName"></div>
                </div>

                <div class="form-group">
                    <label for="address">Physical Address <span class="required">*</span></label>
                    <textarea id="address" name="address" placeholder="House number, street, suburb, city" required></textarea>
                    <div class="error-message" data-error-for="address"></div>
                </div>

                <div class="form-group">
                    <label for="nationalId">National ID Number <span class="required">*</span></label>
                    <input type="text" id="nationalId" name="nationalId" placeholder="e.g. 12-345678 A 90" required />
                    <div class="error-message" data-error-for="nationalId"></div>
                </div>

                <div class="form-group">
                    <label for="idUpload">Upload National ID (Front &amp; Back) <span class="required">*</span></label>
                    <input type="file" id="idUpload" name="idUpload" accept="image/*,application/pdf" required />
                    <div class="error-message" data-error-for="idUpload"></div>
                </div>

                <div class="divider"></div>

                <div style="display:flex; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back</a>
                    <button type="submit" class="btn btn-primary">Continue &amp; Submit</button>
                </div>
            </form>

            <div id="successSection" class="text-center" style="display:none;">
                <div class="badge-step"><span class="step-dot"></span> Step 2 of 2 – Confirmation</div>
                <div class="success-icon" id="successIcon"></div>
                <h2 class="section-title">Account Successfully Registered</h2>
                <p class="section-subtitle">Thank you for registering with NBS. Your application has been received and is now under review.</p>
                <p>Your reference number is:<br /><span class="ref-box" id="refNumber"></span></p>
                <div class="divider"></div>
                <p class="section-subtitle">An NBS representative may contact you to finalise your account opening or request any additional information if needed.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Start a New Application</a>
            </div>
        </div>
    </main>

    <footer>NBS – Secure, Simple &amp; Convenient Banking.</footer>
    
</div>

<script>
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    }
    function generateReferenceNumber() {
        const randomPart = Math.floor(100000 + Math.random() * 899999);
        return 'NBS-' + randomPart;
    }

    const form = document.getElementById('registrationForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();

        let isValid = true;
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const address = document.getElementById('address');
        const nationalId = document.getElementById('nationalId');
        const idUpload = document.getElementById('idUpload');
        const maxFileSizeBytes = 5 * 1024 * 1024; // 5MB

        function setError(inputId, message) {
            const errorEl = document.querySelector('[data-error-for="' + inputId + '"]');
            if (errorEl) errorEl.textContent = message;
            isValid = false;
        }

        if (!firstName.value.trim()) setError('firstName', 'Please enter your first name.');
        if (!lastName.value.trim()) setError('lastName', 'Please enter your surname.');
        if (!address.value.trim()) setError('address', 'Please enter your physical address.');
        if (!nationalId.value.trim()) setError('nationalId', 'Please enter your National ID number.');
        if (!idUpload.files || idUpload.files.length === 0) {
            setError('idUpload', 'Please upload an image or PDF of your National ID.');
        } else if (idUpload.files[0].size > maxFileSizeBytes) {
            setError('idUpload', 'File size exceeds 5MB limit.');
        }

        if (!isValid) return;

        // Simulate success
        const ref = generateReferenceNumber();
        document.getElementById('refNumber').textContent = ref;
        document.getElementById('refNumber').style.display = 'inline-block';
        document.getElementById('successIcon').style.display = 'flex';
        document.getElementById('successSection').style.display = 'block';
        form.style.display = 'none';
    });
</script>
</body>
</html>

