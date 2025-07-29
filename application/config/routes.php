<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Pablo's Barber Custom Routes
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
| Add these routes to your existing application/config/routes.php file
*/

// Pablo's Barber main booking page (Beautinda style)
$route['pablo'] = 'pablo_booking/index';
$route['pablo-barber'] = 'pablo_booking/index';
$route['booking'] = 'pablo_booking/index';

// API endpoints for Pablo's booking system
$route['api/pablo/services'] = 'pablo_booking/get_services';
$route['api/pablo/staff'] = 'pablo_booking/get_staff';
$route['api/pablo/slots'] = 'pablo_booking/get_available_slots';
$route['api/pablo/book'] = 'pablo_booking/book_appointment';
$route['api/pablo/cancel/(:num)'] = 'pablo_booking/cancel_appointment/$1';

// Customer portal routes
$route['customer/dashboard'] = 'pablo_customer/dashboard';
$route['customer/appointments'] = 'pablo_customer/appointments';
$route['customer/profile'] = 'pablo_customer/profile';
$route['customer/reviews'] = 'pablo_customer/reviews';

// Review system routes
$route['reviews'] = 'pablo_reviews/index';
$route['reviews/add'] = 'pablo_reviews/add_review';
$route['reviews/(:num)'] = 'pablo_reviews/view/$1';

// Admin routes for Pablo's custom features
$route['admin/pablo'] = 'pablo_admin/dashboard';
$route['admin/pablo/analytics'] = 'pablo_admin/analytics';
$route['admin/pablo/reviews'] = 'pablo_admin/reviews';
$route['admin/pablo/settings'] = 'pablo_admin/settings';
$route['admin/pablo/notifications'] = 'pablo_admin/notifications';

// Legacy compatibility - redirect old booking URLs
$route['appointments'] = 'pablo_booking/index';
$route['book'] = 'pablo_booking/index';

// SEO-friendly service pages
$route['services'] = 'pablo_services/index';
$route['services/(:any)'] = 'pablo_services/view/$1';
$route['preise'] = 'pablo_services/pricing';

// Staff profile pages
$route['team'] = 'pablo_staff/index';
$route['team/pablo'] = 'pablo_staff/profile/pablo';
$route['team/emo'] = 'pablo_staff/profile/emo';

// Contact and info pages
$route['kontakt'] = 'pablo_info/contact';
$route['oeffnungszeiten'] = 'pablo_info/hours';
$route['anfahrt'] = 'pablo_info/directions';

// Booking confirmation and management
$route['termin/bestaetigung/(:any)'] = 'pablo_booking/confirmation/$1';
$route['termin/stornieren/(:any)'] = 'pablo_booking/cancel/$1';
$route['termin/aendern/(:any)'] = 'pablo_booking/reschedule/$1';

// Gift cards and promotions
$route['gutscheine'] = 'pablo_promotions/gift_cards';
$route['aktionen'] = 'pablo_promotions/current_offers';

// Webhook endpoints for integrations
$route['webhook/sms/(:any)'] = 'pablo_webhooks/sms_status/$1';
$route['webhook/payment/(:any)'] = 'pablo_webhooks/payment_status/$1';
$route['webhook/calendar/(:any)'] = 'pablo_webhooks/calendar_sync/$1';

// Mobile app API endpoints
$route['mobile/api/login'] = 'pablo_mobile_api/login';
$route['mobile/api/appointments'] = 'pablo_mobile_api/appointments';
$route['mobile/api/book'] = 'pablo_mobile_api/book_appointment';

// Social media integration
$route['instagram-booking/(:any)'] = 'pablo_social/instagram_booking/$1';
$route['facebook-booking/(:any)'] = 'pablo_social/facebook_booking/$1';

// Emergency and maintenance routes
$route['wartung'] = 'pablo_maintenance/index';
$route['notfall-termine'] = 'pablo_emergency/index';

// Multi-language support (if needed in future)
$route['en/booking'] = 'pablo_booking/index/en';
$route['tr/randevu'] = 'pablo_booking/index/tr';

/* End of file pablo_routes.php */
/* Location: ./application/config/pablo_routes.php */