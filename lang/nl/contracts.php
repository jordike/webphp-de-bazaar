<?php

return [
    'create' => [
        'title' => 'Contract aanmaken',
        'start_date' => 'Startdatum',
        'end_date' => 'Einddatum',
        'create_button' => 'Contract aanmaken',
        'cancel_button' => 'Annuleren',
    ],
    'edit' => [
        'title' => 'Contract bewerken',
        'start_date' => 'Startdatum',
        'end_date' => 'Einddatum',
        'upload_pdf' => 'Contract PDF uploaden',
        'signed' => 'Is het contract ondertekend?',
        'update_button' => 'Contract bijwerken',
        'cancel_button' => 'Annuleren',
        'go_back_button' => 'Ga terug',
    ],
    'messages' => [
        'success' => [
            'created' => 'Contract succesvol aangemaakt!',
            'updated' => 'Contract succesvol bijgewerkt!',
            'deleted' => 'Contract succesvol verwijderd!',
        ],
        'error' => [
            'not_belong' => 'Contract behoort niet tot het opgegeven bedrijf!',
            'signed_update' => 'Een ondertekend contract kan niet worden bijgewerkt!',
            'signed_delete' => 'Een ondertekend contract kan niet worden verwijderd!',
        ],
    ],
];