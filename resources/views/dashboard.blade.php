<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>NBS Mobile Account Opening</title>
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--nbs-grey);
            color: var(--nbs-text);
        }

        .app-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: var(--nbs-green);
            color: var(--nbs-white);
            padding: 1rem 1.25rem;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.4rem;
        }

        header p {
            margin: 0.35rem 0 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        main {
            flex: 1;
            padding: 1.25rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: var(--nbs-white);
            border-radius: 0.85rem;
            padding: 1.25rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .view {
            display: none;
        }

        .view.active {
            display: block;
        }

        .menu-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .qr-container img {
            width: clamp(160px, 40vw, 240px);
            height: auto;
            border-radius: 0.5rem;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: transform 0.08s ease, box-shadow 0.12s ease, background 0.12s ease;
        }

        .btn-primary {
            background: var(--nbs-green);
            color: var(--nbs-white);
            box-shadow: 0 4px 10px rgba(0, 139, 58, 0.35);
        }

        .btn-primary:hover {
            background: var(--nbs-green-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--nbs-white);
            color: var(--nbs-green-dark);
            border: 1px solid rgba(0, 139, 58, 0.3);
        }

        .btn-outline:hover {
            background: var(--nbs-green-light);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--nbs-green-light);
            color: var(--nbs-green-dark);
        }

        .btn-secondary:hover {
            background: #d3f1de;
        }

        .btn-sm {
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
            width: auto;
        }

        .section-title {
            margin: 0 0 0.5rem;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .section-subtitle {
            margin: 0 0 1.2rem;
            font-size: 0.9rem;
            color: #555;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            padding: 0.7rem 0.75rem;
            border-radius: 0.55rem;
            border: 1px solid #d0d0d0;
            font-size: 0.95rem;
            width: 100%;
        }

        textarea {
            min-height: 70px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--nbs-green);
            box-shadow: 0 0 0 2px rgba(0, 139, 58, 0.18);
        }

        .hint {
            font-size: 0.78rem;
            color: #777;
        }

        .error-message {
            font-size: 0.8rem;
            color: #c21b1b;
        }

        .required {
            color: #c21b1b;
        }

        .divider {
            height: 1px;
            background: #e5e5e5;
            margin: 1rem 0;
        }

        .text-center {
            text-align: center;
        }

        .badge-step {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--nbs-green-light);
            color: var(--nbs-green-dark);
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.78rem;
            margin-bottom: 0.6rem;
        }

        .badge-step span.step-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--nbs-green-dark);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--nbs-green);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            background: var(--nbs-green-light);
        }

        .success-icon::before {
            content: "✓";
            font-size: 2.5rem;
            color: var(--nbs-green-dark);
        }

        .ref-box {
            display: inline-block;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            background: var(--nbs-green-light);
            color: var(--nbs-green-dark);
            font-weight: 600;
            font-size: 0.86rem;
        }

        footer {
            text-align: center;
            padding: 0.75rem 1rem 1rem;
            font-size: 0.75rem;
            color: #666;
        }

        @media (min-width: 700px) {
            header h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
<div class="app-container">
    <header>
        <h1>NBS Mobile Account Opening</h1>
        <p>Open your account in a few simple steps.</p>
    </header>

    <main>
        <div class="card">
            <!-- HOME / MENU VIEW -->
            <section id="view-home" class="view active">
                <p class="section-subtitle">
                    Choose how you would like to start your registration.
                </p>

                <div class="qr-container" aria-label="Scan to Register">
                    <div class="badge-step"><span class="step-dot"></span> Scan to Register</div>
                    <img src="{{ asset('img.png') }}" alt="Registration QR Code" />
                    <small class="hint">Open your phone camera or QR app to scan.</small>
                </div>

                <div class="menu-buttons">
                    <a class="btn btn-outline" id="btn-register" href="{{ route('register') }}">✍️ Register Manually</a>
                </div>
            </section>

            <!-- REGISTRATION VIEW -->
            <section id="view-register" class="view">
                <div class="badge-step">
                    <span class="step-dot"></span> Step 1 of 2 – Enter your details
                </div>
                <h2 class="section-title">Customer Registration</h2>
                <p class="section-subtitle">
                    Please provide your details as they appear on your National ID.
                </p>

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
                        <input
                            type="file"
                            id="idUpload"
                            name="idUpload"
                            accept="image/*,application/pdf"
                            required
                        />
                        <div class="hint">
                            Allowed: JPG, PNG, PDF. Maximum size: 5MB.
                        </div>
                        <div class="error-message" data-error-for="idUpload"></div>
                    </div>

                    <div class="divider"></div>

                    <div style="display:flex; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;">
                        <button type="button" class="btn btn-secondary btn-sm" id="btn-back-home">
                            ← Back
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Continue &amp; Submit
                        </button>
                    </div>
                </form>
            </section>

            <!-- SUCCESS VIEW -->
            <section id="view-success" class="view">
                <div class="badge-step">
                    <span class="step-dot"></span> Step 2 of 2 – Confirmation
                </div>

                <div class="text-center">
                    <div class="success-icon"></div>
                    <h2 class="section-title">Account Successfully Registered</h2>
                    <p class="section-subtitle">
                        Thank you for registering with NBS. Your application has been received and is now under review.
                    </p>

                    <p>
                        Your reference number is:<br />
                        <span class="ref-box" id="refNumber">NBS-000000</span>
                    </p>

                    <div class="divider"></div>

                    <p class="section-subtitle">
                        An NBS representative may contact you to finalise your account opening or request any additional
                        information if needed.
                    </p>

                    <button class="btn btn-primary" id="btn-new-app">
                        Start a New Application
                    </button>
                </div>
            </section>
        </div>
    </main>

    <footer>
        NBS – Secure, Simple &amp; Convenient Banking.
    </footer>
</div>

<script>
    // Helper to switch views
    function showView(viewId) {
        document.querySelectorAll(".view").forEach(function (v) {
            v.classList.remove("active");
        });
        var view = document.getElementById(viewId);
        if (view) {
            view.classList.add("active");
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }

    // QR code is displayed inline on the home view now

    // 'Register Manually' now navigates to its dedicated route via anchor link

    // Back button from registration to home
    document.getElementById("btn-back-home").addEventListener("click", function () {
        showView("view-home");
    });

    // Start a new application from success view
    document.getElementById("btn-new-app").addEventListener("click", function () {
        // Reset form and go to home
        document.getElementById("registrationForm").reset();
        clearErrors();
        showView("view-home");
    });

    // Handle form submission
    const form = document.getElementById("registrationForm");

    function clearErrors() {
        document
            .querySelectorAll(".error-message")
            .forEach(function (el) {
                el.textContent = "";
            });
    }

    function generateReferenceNumber() {
        // Simple random ref number generator for demo
        const randomPart = Math.floor(100000 + Math.random() * 899999);
        return "NBS-" + randomPart;
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        clearErrors();

        let isValid = true;

        const firstName = document.getElementById("firstName");
        const lastName = document.getElementById("lastName");
        const address = document.getElementById("address");
        const nationalId = document.getElementById("nationalId");
        const idUpload = document.getElementById("idUpload");
        const maxFileSizeBytes = 5 * 1024 * 1024; // 5MB

        function setError(inputId, message) {
            const errorEl = document.querySelector('[data-error-for="' + inputId + '"]');
            if (errorEl) {
                errorEl.textContent = message;
            }
            isValid = false;
        }

        if (!firstName.value.trim()) {
            setError("firstName", "Please enter your first name.");
        }

        if (!lastName.value.trim()) {
            setError("lastName", "Please enter your surname.");
        }

        if (!address.value.trim()) {
            setError("address", "Please enter your physical address.");
        }

        if (!nationalId.value.trim()) {
            setError("nationalId", "Please enter your National ID number.");
        }

        if (!idUpload.files || idUpload.files.length === 0) {
            setError("idUpload", "Please upload an image or PDF of your National ID.");
        } else {
            const file = idUpload.files[0];
            if (file.size > maxFileSizeBytes) {
                setError("idUpload", "File size exceeds 5MB limit.");
            }
        }

        if (!isValid) {
            return;
        }

        // In a real implementation, you would POST this data to a backend API here.

        const ref = generateReferenceNumber();
        document.getElementById("refNumber").textContent = ref;

        // Show success view
        showView("view-success");
    });
</script>
</body>
</html>
