<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pablo's Barber Custom Booking Controller
 * Beautinda-style booking workflow
 */
class Pablo_booking extends EA_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('services_model');
        $this->load->model('providers_model');
        $this->load->model('customers_model');
        $this->load->model('appointments_model');
        $this->load->model('settings_model');
        
        $this->load->library('session');
        $this->load->helper(['url', 'language', 'form']);
    }
    
    /**
     * Main booking page - Beautinda Style
     */
    public function index()
    {
        try {
            $view_data = $this->prepare_booking_data();
            $this->load->view('pablo/booking_page', $view_data);
        } catch (Exception $e) {
            show_error('Booking page could not be loaded: ' . $e->getMessage());
        }
    }
    
    /**
     * Get Pablo's services with prices
     */
    public function get_services()
    {
        try {
            $services = [
                [
                    'id' => 1,
                    'name' => 'Männerhaarschnitt (50)',
                    'price' => 22.00,
                    'duration' => 30,
                    'description' => 'Professioneller Herrenhaarschnitt',
                    'category' => 'Haarschnitt'
                ],
                [
                    'id' => 2,
                    'name' => 'Der Kleine Schnitt',
                    'price' => 18.00,
                    'duration' => 20,
                    'description' => 'Kurzer Nachschnitt',
                    'category' => 'Haarschnitt'
                ],
                [
                    'id' => 3,
                    'name' => 'Haare + Bart',
                    'price' => 35.00,
                    'duration' => 45,
                    'description' => 'Komplettes Styling für Haare und Bart',
                    'category' => 'Kombi'
                ],
                [
                    'id' => 4,
                    'name' => 'Bartschnitt',
                    'price' => 14.00,
                    'duration' => 15,
                    'description' => 'Professionelle Bartpflege',
                    'category' => 'Bart'
                ],
                [
                    'id' => 5,
                    'name' => 'Haareschneiden',
                    'price' => 24.00,
                    'duration' => 30,
                    'description' => 'Klassischer Haarschnitt',
                    'category' => 'Haarschnitt'
                ],
                [
                    'id' => 6,
                    'name' => 'Augenbrauen zupfen',
                    'price' => 18.00,
                    'duration' => 15,
                    'description' => 'Präzise Augenbrauenpflege',
                    'category' => 'Pflege'
                ],
                [
                    'id' => 7,
                    'name' => 'Gesicht mit Maske',
                    'price' => 23.00,
                    'duration' => 25,
                    'description' => 'Entspannende Gesichtsbehandlung',
                    'category' => 'Pflege'
                ],
                [
                    'id' => 8,
                    'name' => 'Hot Towels',
                    'price' => 12.00,
                    'duration' => 10,
                    'description' => 'Entspannende heiße Handtücher',
                    'category' => 'Wellness'
                ],
                [
                    'id' => 9,
                    'name' => 'Kinder bis 14 Jahren',
                    'price' => 16.00,
                    'duration' => 25,
                    'description' => 'Kindgerechter Haarschnitt',
                    'category' => 'Kinder'
                ],
                [
                    'id' => 10,
                    'name' => 'Komplettes Paket',
                    'price' => 54.00,
                    'duration' => 90,
                    'description' => 'Gesicht + Bart + Augenbrauen + Massage + Hot Towel',
                    'category' => 'Premium'
                ],
                [
                    'id' => 11,
                    'name' => 'Komplettes Styling/Tour',
                    'price' => 44.00,
                    'duration' => 60,
                    'description' => 'Vollständiges Styling-Erlebnis',
                    'category' => 'Premium'
                ]
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($services));
                
        } catch (Exception $e) {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => $e->getMessage()]));
        }
    }
    
    /**
     * Get staff members (Pablo & Emo)
     */
    public function get_staff()
    {
        try {
            $staff = [
                [
                    'id' => 1,
                    'name' => 'Pablo',
                    'role' => 'Master Barber',
                    'avatar' => 'P',
                    'specialties' => ['Herrenschnitt', 'Bartpflege', 'Styling'],
                    'available_hours' => $this->get_working_hours()
                ],
                [
                    'id' => 2,
                    'name' => 'Emo',
                    'role' => 'Senior Barber',
                    'avatar' => 'E',
                    'specialties' => ['Herrenschnitt', 'Moderne Schnitte'],
                    'available_hours' => $this->get_working_hours()
                ]
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($staff));
                
        } catch (Exception $e) {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => $e->getMessage()]));
        }
    }
    
    /**
     * Get available time slots for a specific date and staff member
     */
    public function get_available_slots()
    {
        try {
            $date = $this->input->post('date');
            $staff_id = $this->input->post('staff_id');
            $service_duration = $this->input->post('duration', TRUE);
            
            if (!$date || !$staff_id) {
                throw new Exception('Date and staff ID are required');
            }
            
            $slots = $this->calculate_available_slots($date, $staff_id, $service_duration);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($slots));
                
        } catch (Exception $e) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => $e->getMessage()]));
        }
    }
    
    /**
     * Process booking request
     */
    public function book_appointment()
    {
        try {
            $booking_data = [
                'service_id' => $this->input->post('service_id'),
                'staff_id' => $this->input->post('staff_id'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_phone' => $this->input->post('customer_phone'),
                'customer_email' => $this->input->post('customer_email'),
                'notes' => $this->input->post('notes')
            ];
            
            // Validate required fields
            $this->validate_booking_data($booking_data);
            
            // Create customer if doesn't exist
            $customer_id = $this->find_or_create_customer($booking_data);
            
            // Create appointment
            $appointment_id = $this->create_appointment($booking_data, $customer_id);
            
            // Send confirmation
            $this->send_booking_confirmation($appointment_id);
            
            $response = [
                'success' => true,
                'appointment_id' => $appointment_id,
                'message' => 'Termin erfolgreich gebucht!'
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
                
        } catch (Exception $e) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]));
        }
    }
    
    /**
     * Prepare data for booking page
     */
    private function prepare_booking_data()
    {
        $data = [
            'company_name' => 'Pablos Barber',
            'company_subtitle' => 'Dein Studio in Lauffen am Neckar',
            'base_url' => base_url(),
            'opening_hours' => [
                'monday' => 'Geschlossen',
                'tuesday' => '10:00 - 19:00',
                'wednesday' => '10:00 - 19:00',
                'thursday' => '10:00 - 19:00',
                'friday' => '10:00 - 19:00',
                'saturday' => '10:00 - 18:00',
                'sunday' => 'Geschlossen'
            ],
            'contact_info' => [
                'address' => 'Lauffen am Neckar',
                'phone' => '+49 (0) XXX XXXXX',
                'email' => 'info@pablosbarber.de'
            ]
        ];
        
        return $data;
    }
    
    /**
     * Get working hours for staff
     */
    private function get_working_hours()
    {
        return [
            'tuesday' => ['start' => '10:00', 'end' => '19:00'],
            'wednesday' => ['start' => '10:00', 'end' => '19:00'],
            'thursday' => ['start' => '10:00', 'end' => '19:00'],
            'friday' => ['start' => '10:00', 'end' => '19:00'],
            'saturday' => ['start' => '10:00', 'end' => '18:00'],
        ];
    }
    
    /**
     * Calculate available time slots
     */
    private function calculate_available_slots($date, $staff_id, $duration = 30)
    {
        $day_of_week = strtolower(date('l', strtotime($date)));
        $working_hours = $this->get_working_hours();
        
        // Check if salon is open
        if (!isset($working_hours[$day_of_week])) {
            return []; // Closed day
        }
        
        $start_time = $working_hours[$day_of_week]['start'];
        $end_time = $working_hours[$day_of_week]['end'];
        
        $slots = [];
        $current_time = strtotime($date . ' ' . $start_time);
        $end_timestamp = strtotime($date . ' ' . $end_time);
        
        while ($current_time < $end_timestamp) {
            $slot_time = date('H:i', $current_time);
            
            // Check if slot is available (not booked)
            if ($this->is_slot_available($date, $slot_time, $staff_id)) {
                $slots[] = [
                    'time' => $slot_time,
                    'available' => true
                ];
            }
            
            $current_time += (30 * 60); // 30-minute intervals
        }
        
        return $slots;
    }
    
    /**
     * Check if time slot is available
     */
    private function is_slot_available($date, $time, $staff_id)
    {
        // Check against existing appointments
        $existing_appointments = $this->appointments_model->get_batch([
            'start_datetime >=' => $date . ' ' . $time,
            'start_datetime <' => $date . ' ' . date('H:i', strtotime($time . ' +30 minutes')),
            'id_users_provider' => $staff_id
        ]);
        
        return empty($existing_appointments);
    }
    
    /**
     * Validate booking data
     */
    private function validate_booking_data($data)
    {
        $required_fields = ['service_id', 'staff_id', 'date', 'time', 'customer_name', 'customer_phone'];
        
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Field '{$field}' is required");
            }
        }
        
        // Validate phone number
        if (!preg_match('/^[\d\+\-\s\(\)]+$/', $data['customer_phone'])) {
            throw new Exception('Invalid phone number format');
        }
        
        // Validate email if provided
        if (!empty($data['customer_email']) && !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
    }
    
    /**
     * Find existing customer or create new one
     */
    private function find_or_create_customer($data)
    {
        // Try to find existing customer by phone
        $existing_customer = $this->customers_model->get_batch(['phone_number' => $data['customer_phone']]);
        
        if (!empty($existing_customer)) {
            return $existing_customer[0]['id'];
        }
        
        // Create new customer
        $customer_data = [
            'first_name' => $data['customer_name'],
            'last_name' => '',
            'email' => $data['customer_email'] ?? '',
            'phone_number' => $data['customer_phone'],
            'address' => '',
            'city' => '',
            'zip_code' => '',
            'notes' => $data['notes'] ?? ''
        ];
        
        return $this->customers_model->add($customer_data);
    }
    
    /**
     * Create appointment
     */
    private function create_appointment($data, $customer_id)
    {
        $start_datetime = $data['date'] . ' ' . $data['time'] . ':00';
        $service_duration = 30; // Default, should be fetched from service
        $end_datetime = date('Y-m-d H:i:s', strtotime($start_datetime . ' +' . $service_duration . ' minutes'));
        
        $appointment_data = [
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'notes' => $data['notes'] ?? '',
            'id_users_provider' => $data['staff_id'],
            'id_users_customer' => $customer_id,
            'id_services' => $data['service_id']
        ];
        
        return $this->appointments_model->add($appointment_data);
    }
    
    /**
     * Send booking confirmation
     */
    private function send_booking_confirmation($appointment_id)
    {
        // This would integrate with your email/SMS system
        // For now, just log the confirmation
        log_message('info', 'Booking confirmation sent for appointment ID: ' . $appointment_id);
        
        // TODO: Implement actual email/SMS sending
        // $this->load->library('email');
        // $this->email->from('noreply@pablosbarber.de', 'Pablos Barber');
        // $this->email->to($customer_email);
        // $this->email->subject('Terminbestätigung - Pablos Barber');
        // $this->email->message($confirmation_message);
        // $this->email->send();
    }
}