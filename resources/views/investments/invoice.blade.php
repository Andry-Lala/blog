<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $investment->id }} - {{ config('app.name', 'Blog') }}</title>
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .invoice-header .invoice-info {
            margin-top: 10px;
            font-size: 14px;
        }
        .invoice-header .invoice-info div {
            margin-bottom: 5px;
        }
        .invoice-details {
            padding: 0 20px;
        }
        .invoice-details h2 {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item strong {
            color: #1f2937;
            display: block;
            margin-bottom: 5px;
        }
        .info-item span {
            color: #6b7280;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-validé {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-envoyé {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-en-cours {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                border: 1px solid #000;
            }
            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>FACTURE</h1>
            <div class="invoice-info">
                <div><strong>Facture #:</strong> {{ $investment->id }}</div>
                <div><strong>Date:</strong> {{ $investment->created_at->format('d/m/Y') }}</div>
                <div><strong>Client:</strong> {{ $investment->user->first_name }} {{ $investment->user->last_name }}</div>
            </div>
        </div>

        <div class="invoice-details">
            <h2>Détails de l'investissement</h2>

            <div class="info-grid">
                <div class="info-item">
                    <strong>Type d'investissement:</strong>
                    <span>{{ $investment->investment_type }}</span>
                </div>
                <div class="info-item">
                    <strong>Opérateur:</strong>
                    <span>{{ $investment->operator }}</span>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <strong>Montant investi:</strong>
                    <span>{{ number_format($investment->amount, 2, ',', ' ') }} Ar</span>
                </div>
                <div class="info-item">
                    <strong>Statut:</strong>
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $investment->status)) }}">
                        {{ $investment->status }}
                    </span>
                </div>
            </div>

            @if($investment->admin_notes)
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Notes administrateur:</strong>
                        <span>{{ $investment->admin_notes }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="footer">
            <p>Merci pour votre confiance dans notre plateforme d'investissement.</p>
            <p>Cette facture est générée automatiquement et n'a pas de valeur fiscale.</p>
            <p>Contactez-nous pour toute question : contact@blog.com</p>
        </div>
    </div>
</body>
</html>
