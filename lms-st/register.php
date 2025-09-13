<?php $cfg = require __DIR__ . '/config.php'; $site = $cfg['site_name'] ?? 'EduLearn'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Complete Registration — <?php echo htmlspecialchars($site); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body class="bg-soft">

    <main class="section hero">
        <div class="container" style="max-width: 960px;">
            <a href="index.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>

            <div class="form-card">
                <div class="form-card-header">
                    <div class="brand"><span class="logo"></span><span>Complete Registration</span></div>
                    <div class="muted">Please provide your details to get started</div>
                    <div class="stepper" id="stepper">
                        <div class="step active">1</div>
                        <div class="step">2</div>
                        <div class="step">3</div>
                        <div class="step">4</div>
                    </div>
                </div>

                <form id="regForm" action="#" method="post" novalidate>
                    <!-- Step 1: Academic Information -->
                    <section class="form-step active" data-step="1">
                        <h3 class="form-title">Academic Information</h3>
                        <p class="muted">Tell us about your studies</p>
                        <div class="form-grid">
                            <div class="label-input-container">
                                <label for="exam_year" class="form-label">A/L Exam Year *</label>
                                <div class="input-wrapper" data-input-type="select">
                                    <i class="fa-solid fa-calendar leading-icon" aria-hidden="true"></i>
                                    <select id="exam_year" class="input" name="exam_year" required>
                                        <option value="">Select exam year</option>
                                        <?php for ($y = (int)date('Y'); $y >= (int)date('Y')-6; $y--) echo "<option>$y</option>"; ?>
                                    </select>
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="institute" class="form-label">Institute *</label>
                                <div class="input-wrapper" data-input-type="select">
                                    <i class="fa-solid fa-school leading-icon" aria-hidden="true"></i>
                                    <select id="institute" class="input" name="institute" required>
                                        <option value="">Select institute</option>
                                        <option>School</option>
                                        <option>Private</option>
                                    </select>
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="student_type" class="form-label">Student Type *</label>
                                <div class="input-wrapper" data-input-type="select">
                                    <i class="fa-solid fa-user-group leading-icon" aria-hidden="true"></i>
                                    <select id="student_type" class="input" name="student_type" required>
                                        <option value="">Select student type</option>
                                        <option>School Student</option>
                                        <option>Private Candidate</option>
                                    </select>
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="stream" class="form-label">Stream *</label>
                                <div class="input-wrapper" data-input-type="select">
                                    <i class="fa-solid fa-layer-group leading-icon" aria-hidden="true"></i>
                                    <select id="stream" class="input" name="stream" required>
                                        <option value="">Select your stream</option>
                                        <option>E.TECH</option>
                                        <option>Commerce</option>
                                        <option>Science</option>
                                    </select>
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn" data-prev disabled>Previous</button>
                            <button type="button" class="btn primary" data-next>Next</button>
                        </div>
                    </section>

                    <!-- Step 2: Personal Information -->
                    <section class="form-step" data-step="2">
                        <h3 class="form-title">Personal Information</h3>
                        <p class="muted">Tell us about yourself</p>
                        <div class="form-grid">
                            <div class="label-input-container">
                                <label for="first_name" class="form-label">First Name *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user leading-icon" aria-hidden="true"></i>
                                    <input id="first_name" class="input" type="text" name="first_name" placeholder="Enter your first name" value="<?php echo htmlspecialchars($_GET['first_name'] ?? ''); ?>" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user leading-icon" aria-hidden="true"></i>
                                    <input id="last_name" class="input" type="text" name="last_name" placeholder="Enter your last name" value="<?php echo htmlspecialchars($_GET['last_name'] ?? ''); ?>" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container full">
                                <label for="address" class="form-label">Address *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-house leading-icon" aria-hidden="true"></i>
                                    <input id="address" class="input" type="text" name="address" placeholder="Enter your full address" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="district" class="form-label">District *</label>
                                <div class="input-wrapper" data-input-type="select">
                                    <i class="fa-solid fa-location-dot leading-icon" aria-hidden="true"></i>
                                    <select id="district" class="input" name="district" required>
                                        <option value="">Select your district</option>
                                        <option>Colombo</option>
                                        <option>Gampaha</option>
                                        <option>Kalutara</option>
                                    </select>
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="mobile" class="form-label">Mobile Number *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone leading-icon" aria-hidden="true"></i>
                                    <input id="mobile" class="input" type="tel" name="mobile" placeholder="Enter your mobile number" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="whatsapp" class="form-label">WhatsApp Number *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone leading-icon" aria-hidden="true"></i>
                                    <input id="whatsapp" class="input" type="tel" name="whatsapp" placeholder="Enter your WhatsApp number" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="nic" class="form-label">National ID Number *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-id-card leading-icon" aria-hidden="true"></i>
                                    <input id="nic" class="input" type="text" name="nic" placeholder="Enter your NIC number" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="school" class="form-label">School *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-school leading-icon" aria-hidden="true"></i>
                                    <input id="school" class="input" type="text" name="school" placeholder="Enter your school name" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn" data-prev>Previous</button>
                            <button type="button" class="btn primary" data-next>Next</button>
                        </div>
                    </section>

                    <!-- Step 3: Account Information -->
                    <section class="form-step" data-step="3">
                        <h3 class="form-title">Account & Confirmation</h3>
                        <p class="muted">Create your login and confirm details</p>
                        <div class="form-grid">
                            <div class="label-input-container">
                                <label for="email" class="form-label">Email *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-envelope leading-icon" aria-hidden="true"></i>
                                    <input id="email" class="input" type="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-lock leading-icon" aria-hidden="true"></i>
                                    <input id="password" class="input" type="password" name="password" placeholder="Create a password" minlength="6" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container full">
                                <label for="notes" class="form-label">Notes</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-note-sticky leading-icon" aria-hidden="true"></i>
                                    <textarea id="notes" class="input" name="notes" rows="3" placeholder="Any additional information (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn" data-prev>Previous</button>
                            <button type="button" class="btn primary" data-next>Next</button>
                        </div>
                    </section>

                    <!-- Step 4: Parent Information -->
                    <section class="form-step" data-step="4">
                        <h3 class="form-title">Parent Information</h3>
                        <p class="muted">Guardian contact details</p>
                        <div class="form-grid">
                            <div class="label-input-container">
                                <label for="parent_name" class="form-label">Parent/Guardian Name *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user leading-icon" aria-hidden="true"></i>
                                    <input id="parent_name" class="input" type="text" name="parent_name" placeholder="Enter parent/guardian name" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                            <div class="label-input-container">
                                <label for="parent_contact" class="form-label">Parent/Guardian Contact Number *</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone leading-icon" aria-hidden="true"></i>
                                    <input id="parent_contact" class="input" type="tel" name="parent_contact" placeholder="Enter contact number" required />
                                    <small class="error-msg"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn" data-prev>Previous</button>
                            <button type="submit" class="btn primary">Complete Registration</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="copyright">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site); ?>. All rights reserved.</div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
