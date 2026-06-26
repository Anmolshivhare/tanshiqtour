@php
    $settings = \App\Helpers\SiteSettingHelper::bag();
    $companyName = $settings->company_name ?? 'Tanishq Tour & Travel';
    $logo = \App\Helpers\SiteSettingHelper::imageUrl('header_logo', 'resources/images/Tanishq Tour & Travels.png');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Tour Enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f4f7fb;padding:28px 12px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:680px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:24px 28px;background:#022179;text-align:center;">
                            <img src="{{ $logo }}" alt="{{ $companyName }}" style="max-width:180px;max-height:72px;background:#ffffff;border-radius:8px;padding:8px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <h1 style="margin:0 0 10px;font-size:24px;line-height:1.3;color:#111827;">New Tour Enquiry</h1>
                            <p style="margin:0 0 24px;font-size:15px;line-height:1.6;color:#4b5563;">A visitor wants to book <strong>{{ $tour->title }}</strong>.</p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;width:160px;">Tour</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $tour->title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Name</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Email</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;"><a href="mailto:{{ $enquiry->email }}" style="color:#022179;">{{ $enquiry->email }}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Phone</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Subject</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->subject }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">City</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Travel Date</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->travel_date?->format('d M Y') ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:bold;">Travellers</td>
                                    <td style="padding:12px;border:1px solid #e5e7eb;">{{ $enquiry->adults }} adult(s), {{ $enquiry->children }} child(ren)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#f9fafb;color:#6b7280;font-size:13px;text-align:center;">
                            Sent from {{ $companyName }} on {{ now()->format('d M Y, h:i A') }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
