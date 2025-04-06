<?php

return [
    'create' => [
        'title' => 'Create contract',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'create_button' => 'Create Contract',
        'cancel_button' => 'Cancel',
    ],
    'edit' => [
        'title' => 'Edit contract',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'upload_pdf' => 'Upload contract PDF',
        'signed' => 'Is the contract signed?',
        'update_button' => 'Update Contract',
        'cancel_button' => 'Cancel',
        'go_back_button' => 'Go back',
    ],
    'messages' => [
        'success' => [
            'created' => 'Contract created successfully!',
            'updated' => 'Contract updated successfully!',
            'deleted' => 'Contract deleted successfully!',
        ],
        'error' => [
            'not_belong' => 'Contract does not belong to the specified company!',
            'signed_update' => 'Cannot update a signed contract!',
            'signed_delete' => 'Cannot delete a signed contract!',
        ],
    ],
];
