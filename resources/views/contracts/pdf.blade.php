<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Contract #{{ $contract->id }}</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
            }

            .container {
                padding: 20px;
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
            }

            .header h1 {
                margin: 0;
            }

            .details {
                margin-bottom: 20px;
            }

            .details p {
                margin: 5px 0;
            }

            .footer {
                text-align: center;
                margin-top: 30px;
                font-size: 0.9em;
                color: #555;
            }
            .flex-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }

            .details {
                flex: 1;
                min-width: 300px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>Contract</h1>
                <p>Contract ID: #{{ $contract->id }}</p>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <div class="details" style="flex: 1; min-width: 300px;">
                    <h2>Company Details</h2>
                    <p><strong>Company ID:</strong> {{ $company->id }}</p>
                    <p><strong>Company Name:</strong> {{ $company->name }}</p>
                    <p><strong>Email:</strong> {{ $company->email }}</p>
                    <p><strong>Phone:</strong> {{ $company->phone }}</p>
                    <p><strong>Address:</strong> {{ $company->address }}</p>
                    <p><strong>City:</strong> {{ $company->city }}</p>
                </div>

                <div class="details" style="flex: 1; min-width: 300px;">
                    <h2>Contract Details</h2>
                    <p><strong>Start Date:</strong> {{ $contract->start_date->format('d-m-Y') }}</p>
                    <p><strong>End Date:</strong> {{ $contract->end_date->format('d-m-Y') }}</p>
                </div>
            </div>

            <div class="footer">
                <p>Generated on {{ now()->format('d-m-Y H:i:s') }}</p>
            </div>
        </div>
    </body>
</html>
