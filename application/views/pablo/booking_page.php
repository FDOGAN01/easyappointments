<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $company_name; ?> | <?php echo $company_subtitle; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            color: #e74c3c;
            font-size: 1.5rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .hero {
            text-align: center;
            margin-bottom: 3rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .hero h2 {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 2rem;
        }

        .booking-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            background: #ecf0f1;
            color: #7f8c8d;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #e74c3c;
            color: white;
        }

        .step.completed {
            background: #27ae60;
            color: white;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .section-title {
            font-size: 1.3rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 15px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .service-card:hover {
            border-color: #e74c3c;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.1);
        }

        .service-card.selected {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .service-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .service-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e74c3c;
        }

        .service-duration {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .service-description {
            color: #7f8c8d;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .staff-card {
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .staff-card:hover {
            border-color: #e74c3c;
            transform: translateY(-2px);
        }

        .staff-card.selected {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .staff-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #e74c3c;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 auto 1rem;
        }

        .staff-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .staff-role {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .datetime-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .calendar-widget, .time-slots {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            border: 2px solid #ecf0f1;
        }

        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .time-slot {
            padding: 0.75rem 0.5rem;
            border: 1px solid #ecf0f1;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .time-slot:hover {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .time-slot.selected {
            background: #e74c3c;
            color: white;
            border-color: #e74c3c;
        }

        .time-slot.unavailable {
            background: #ecf0f1;
            color: #bdc3c7;
            cursor: not-allowed;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #e74c3c;
        }

        .date-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 1rem;
        }

        .booking-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            border: 2px solid #ecf0f1;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: #e74c3c;
        }

        .btn {
            background: #e74c3c;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
            font-weight: 600;
        }

        .btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }

        .btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: #7f8c8d;
            margin-right: 1rem;
            width: auto;
        }

        .btn-secondary:hover {
            background: #6c757d;
        }

        .opening-hours {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .hours-list {
            list-style: none;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .hours-item:last-child {
            border-bottom: none;
        }

        .day {
            font-weight: 500;
            color: #2c3e50;
        }

        .time {
            color: #7f8c8d;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #e74c3c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .datetime-grid, .form-grid {
                grid-template-columns: 1fr;
            }

            .services-grid, .staff-grid {
                grid-template-columns: 1fr;
            }

            .step-indicator {
                flex-direction: column;
                align-items: center;
            }

            .header-content {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-cut"></i>
                <h1>Beautinda</h1>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="hero">
            <h1><?php echo $company_name; ?></h1>
            <h2><?php echo $company_subtitle; ?></h2>
        </div>

        <div class="booking-section">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" id="step-1">
                    <i class="fas fa-cut"></i>
                    <span>Service wählen</span>
                </div>
                <div class="step" id="step-2">
                    <i class="fas fa-user"></i>
                    <span>Friseur wählen</span>
                </div>
                <div class="step" id="step-3">
                    <i class="fas fa-calendar"></i>
                    <span>Datum & Zeit</span>
                </div>
                <div class="step" id="step-4">
                    <i class="fas fa-user-edit"></i>
                    <span>Kontaktdaten</span>
                </div>
                <div class="step" id="step-5">
                    <i class="fas fa-check"></i>
                    <span>Bestätigung</span>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alert-container"></div>

            <!-- Step 1: Service Selection -->
            <div class="section active" id="section-1">
                <h3 class="section-title">
                    <i class="fas fa-scissors"></i>
                    Wählen Sie Ihren Service
                </h3>
                <div class="services-grid" id="services-container">
                    <!-- Services will be loaded here -->
                </div>
            </div>

            <!-- Step 2: Staff Selection -->
            <div class="section" id="section-2">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Wählen Sie Ihren Friseur
                </h3>
                <div class="staff-grid" id="staff-container">
                    <!-- Staff will be loaded here -->
                </div>
            </div>

            <!-- Step 3: Date & Time Selection -->
            <div class="section" id="section-3">
                <h3 class="section-title">
                    <i class="fas fa-calendar"></i>
                    Datum & Uhrzeit wählen
                </h3>
                <div class="datetime-grid">
                    <div class="calendar-widget">
                        <h4>Datum wählen</h4>
                        <input type="date" id="appointment-date" class="date-input" min="">
                    </div>
                    <div class="time-slots">
                        <h4>Verfügbare Zeiten</h4>
                        <div class="time-slots-grid" id="time-slots-container">
                            <!-- Time slots will be populated here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Customer Information -->
            <div class="section" id="section-4">
                <h3 class="section-title">
                    <i class="fas fa-user-edit"></i>
                    Ihre Kontaktdaten
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="customer-name">Name *</label>
                        <input type="text" id="customer-name" required>
                    </div>
                    <div class="form-group">
                        <label for="customer-phone">Telefonnummer *</label>
                        <input type="tel" id="customer-phone" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="customer-email">E-Mail (optional)</label>
                        <input type="email" id="customer-email">
                    </div>
                    <div class="form-group full-width">
                        <label for="customer-notes">Besondere Wünsche</label>
                        <textarea id="customer-notes" rows="3" placeholder="Optional"></textarea>
                    </div>
                </div>
            </div>

            <!-- Step 5: Booking Summary -->
            <div class="section" id="section-5">
                <h3 class="section-title">
                    <i class="fas fa-receipt"></i>
                    Buchungsübersicht
                </h3>
                <div class="booking-summary">
                    <div class="summary-item">
                        <span>Service:</span>
                        <span id="summary-service">-</span>
                    </div>
                    <div class="summary-item">
                        <span>Friseur:</span>
                        <span id="summary-staff">-</span>
                    </div>
                    <div class="summary-item">
                        <span>Datum:</span>
                        <span id="summary-date">-</span>
                    </div>
                    <div class="summary-item">
                        <span>Uhrzeit:</span>
                        <span id="summary-time">-</span>
                    </div>
                    <div class="summary-item">
                        <span>Gesamtpreis:</span>
                        <span id="summary-price">-</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-container">
                <button class="btn btn-secondary" id="back-btn" onclick="previousStep()" style="display: none;">
                    Zurück
                </button>
                <button class="btn" id="next-btn" onclick="nextStep()" disabled>
                    <span id="btn-text">Weiter</span>
                </button>
            </div>
        </div>

        <!-- Opening Hours -->
        <div class="opening-hours">
            <h3 class="section-title">
                <i class="fas fa-clock"></i>
                Öffnungszeiten
            </h3>
            <ul class="hours-list">
                <?php foreach ($opening_hours as $day => $hours): ?>
                <li class="hours-item">
                    <span class="day"><?php echo ucfirst($day); ?></span>
                    <span class="time"><?php echo $hours; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        // Booking State Management
        const BookingState = {
            currentStep: 1,
            selectedService: null,
            selectedStaff: null,
            selectedDate: null,
            selectedTime: null,
            customerData: {},
            
            reset() {
                this.currentStep = 1;
                this.selectedService = null;
                this.selectedStaff = null;
                this.selectedDate = null;
                this.selectedTime = null;
                this.customerData = {};
            }
        };

        // Initialize booking system
        document.addEventListener('DOMContentLoaded', function() {
            initBookingSystem();
        });

        function initBookingSystem() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('appointment-date').min = today;
            
            // Load initial data
            loadServices();
            loadStaff();
            
            // Setup event listeners
            setupEventListeners();
        }

        function setupEventListeners() {
            // Date change listener
            document.getElementById('appointment-date').addEventListener('change', function() {
                BookingState.selectedDate = this.value;
                if (BookingState.selectedStaff) {
                    loadTimeSlots();
                }
                updateNextButton();
            });

            // Form validation listeners
            ['customer-name', 'customer-phone'].forEach(id => {
                document.getElementById(id).addEventListener('input', updateNextButton);
            });
        }

        async function loadServices() {
            try {
                const response = await fetch('<?php echo base_url(); ?>pablo_booking/get_services');
                const services = await response.json();
                
                const container = document.getElementById('services-container');
                container.innerHTML = '';
                
                services.forEach(service => {
                    const serviceCard = createServiceCard(service);
                    container.appendChild(serviceCard);
                });
            } catch (error) {
                showAlert('Fehler beim Laden der Services', 'error');
                console.error('Error loading services:', error);
            }
        }

        async function loadStaff() {
            try {
                const response = await fetch('<?php echo base_url(); ?>pablo_booking/get_staff');
                const staff = await response.json();
                
                const container = document.getElementById('staff-container');
                container.innerHTML = '';
                
                staff.forEach(member => {
                    const staffCard = createStaffCard(member);
                    container.appendChild(staffCard);
                });
            } catch (error) {
                showAlert('Fehler beim Laden der Mitarbeiter', 'error');
                console.error('Error loading staff:', error);
            }
        }

        async function loadTimeSlots() {
            if (!BookingState.selectedDate || !BookingState.selectedStaff) return;

            const container = document.getElementById('time-slots-container');
            container.innerHTML = '<div class="loading"></div> Verfügbare Zeiten werden geladen...';

            try {
                const formData = new FormData();
                formData.append('date', BookingState.selectedDate);
                formData.append('staff_id', BookingState.selectedStaff.id);
                formData.append('duration', BookingState.selectedService?.duration || 30);

                const response = await fetch('<?php echo base_url(); ?>pablo_booking/get_available_slots', {
                    method: 'POST',
                    body: formData
                });

                const slots = await response.json();
                
                container.innerHTML = '';
                
                if (slots.length === 0) {
                    container.innerHTML = '<p style="color: #e74c3c; text-align: center;">An diesem Tag keine Termine verfügbar</p>';
                    return;
                }
                
                slots.forEach(slot => {
                    const timeSlot = createTimeSlot(slot);
                    container.appendChild(timeSlot);
                });
            } catch (error) {
                container.innerHTML = '<p style="color: #e74c3c;">Fehler beim Laden der Termine</p>';
                console.error('Error loading time slots:', error);
            }
        }

        function createServiceCard(service) {
            const card = document.createElement('div');
            card.className = 'service-card';
            card.dataset.serviceId = service.id;
            
            card.innerHTML = `
                <div class="service-header">
                    <div class="service-name">${service.name}</div>
                    <div class="service-price">${service.price}€</div>
                </div>
                <div class="service-duration">${service.duration} Min.</div>
                <div class="service-description">${service.description}</div>
            `;
            
            card.addEventListener('click', function() {
                selectService(service, this);
            });
            
            return card;
        }

        function createStaffCard(member) {
            const card = document.createElement('div');
            card.className = 'staff-card';
            card.dataset.staffId = member.id;
            
            card.innerHTML = `
                <div class="staff-avatar">${member.avatar}</div>
                <div class="staff-name">${member.name}</div>
                <div class="staff-role">${member.role}</div>
            `;
            
            card.addEventListener('click', function() {
                selectStaff(member, this);
            });
            
            return card;
        }

        function createTimeSlot(slot) {
            const timeSlot = document.createElement('div');
            timeSlot.className = 'time-slot';
            if (!slot.available) {
                timeSlot.classList.add('unavailable');
            }
            timeSlot.textContent = slot.time;
            
            if (slot.available) {
                timeSlot.addEventListener('click', function() {
                    selectTime(slot.time, this);
                });
            }
            
            return timeSlot;
        }

        function selectService(service, element) {
            document.querySelectorAll('.service-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            BookingState.selectedService = service;
            updateNextButton();
        }

        function selectStaff(member, element) {
            document.querySelectorAll('.staff-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            BookingState.selectedStaff = member;
            
            if (BookingState.selectedDate) {
                loadTimeSlots();
            }
            updateNextButton();
        }

        function selectTime(time, element) {
            document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
            element.classList.add('selected');
            BookingState.selectedTime = time;
            updateNextButton();
        }

        function updateNextButton() {
            const btn = document.getElementById('next-btn');
            const btnText = document.getElementById('btn-text');
            let canProceed = false;
            
            switch (BookingState.currentStep) {
                case 1:
                    canProceed = BookingState.selectedService !== null;
                    btnText.textContent = 'Friseur wählen';
                    break;
                case 2:
                    canProceed = BookingState.selectedStaff !== null;
                    btnText.textContent = 'Datum & Zeit wählen';
                    break;
                case 3:
                    canProceed = BookingState.selectedDate && BookingState.selectedTime;
                    btnText.textContent = 'Kontaktdaten eingeben';
                    break;
                case 4:
                    const name = document.getElementById('customer-name').value.trim();
                    const phone = document.getElementById('customer-phone').value.trim();
                    canProceed = name && phone;
                    btnText.textContent = 'Zur Übersicht';
                    break;
                case 5:
                    canProceed = true;
                    btnText.textContent = 'Termin buchen';
                    break;
            }
            
            btn.disabled = !canProceed;
        }

        function nextStep() {
            if (BookingState.currentStep < 5) {
                BookingState.currentStep++;
                updateStepDisplay();
                
                if (BookingState.currentStep === 5) {
                    updateSummary();
                }
            } else {
                bookAppointment();
            }
        }

        function previousStep() {
            if (BookingState.currentStep > 1) {
                BookingState.currentStep--;
                updateStepDisplay();
            }
        }

        function updateStepDisplay() {
            // Update step indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 === BookingState.currentStep) {
                    step.classList.add('active');
                } else if (index + 1 < BookingState.currentStep) {
                    step.classList.add('completed');
                }
            });

            // Show/hide sections
            document.querySelectorAll('.section').forEach((section, index) => {
                section.classList.remove('active');
                if (index + 1 === BookingState.currentStep) {
                    section.classList.add('active');
                }
            });

            // Update navigation buttons
            const backBtn = document.getElementById('back-btn');
            backBtn.style.display = BookingState.currentStep > 1 ? 'inline-block' : 'none';
            
            updateNextButton();
        }

        function updateSummary() {
            document.getElementById('summary-service').textContent = BookingState.selectedService.name;
            document.getElementById('summary-staff').textContent = BookingState.selectedStaff.name;
            document.getElementById('summary-date').textContent = new Date(BookingState.selectedDate).toLocaleDateString('de-DE');
            document.getElementById('summary-time').textContent = BookingState.selectedTime;
            document.getElementById('summary-price').textContent = BookingState.selectedService.price + '€';
        }

        async function bookAppointment() {
            const btn = document.getElementById('next-btn');
            const btnText = document.getElementById('btn-text');
            
            btn.disabled = true;
            btnText.innerHTML = '<div class="loading"></div> Wird gebucht...';

            try {
                const formData = new FormData();
                formData.append('service_id', BookingState.selectedService.id);
                formData.append('staff_id', BookingState.selectedStaff.id);
                formData.append('date', BookingState.selectedDate);
                formData.append('time', BookingState.selectedTime);
                formData.append('customer_name', document.getElementById('customer-name').value);
                formData.append('customer_phone', document.getElementById('customer-phone').value);
                formData.append('customer_email', document.getElementById('customer-email').value);
                formData.append('notes', document.getElementById('customer-notes').value);

                const response = await fetch('<?php echo base_url(); ?>pablo_booking/book_appointment', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Termin erfolgreich gebucht! Sie erhalten eine Bestätigung.', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    throw new Error(result.error || 'Unbekannter Fehler');
                }
            } catch (error) {
                showAlert('Fehler beim Buchen: ' + error.message, 'error');
                btn.disabled = false;
                btnText.textContent = 'Termin buchen';
            }
        }

        function showAlert(message, type) {
            const container = document.getElementById('alert-container');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            
            container.innerHTML = '';
            container.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
</body>
</html>