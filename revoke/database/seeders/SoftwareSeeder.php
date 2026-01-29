<?php

namespace Database\Seeders;

use App\Models\Software;
use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $softwares = [
            [
                'name' => 'Slack',
                'monthly_cost' => 8.50,
                'risk_level' => 'low',
                'website_url' => 'https://slack.com',
            ],
            [
                'name' => 'Jira',
                'monthly_cost' => 7.00,
                'risk_level' => 'high',
                'website_url' => 'https://www.atlassian.com/software/jira',
            ],
            [
                'name' => 'Zoom',
                'monthly_cost' => 15.99,
                'risk_level' => 'low',
                'website_url' => 'https://zoom.us',
            ],
            [
                'name' => 'Figma',
                'monthly_cost' => 12.00,
                'risk_level' => 'low',
                'website_url' => 'https://www.figma.com',
            ],
            [
                'name' => 'AWS',
                'monthly_cost' => 250.00,
                'risk_level' => 'high',
                'website_url' => 'https://aws.amazon.com',
            ],
            [
                'name' => 'GitHub Enterprise',
                'monthly_cost' => 21.00,
                'risk_level' => 'high',
                'website_url' => 'https://github.com/enterprise',
            ],
            [
                'name' => 'Microsoft 365',
                'monthly_cost' => 20.00,
                'risk_level' => 'low',
                'website_url' => 'https://www.microsoft.com/microsoft-365',
            ],
            [
                'name' => 'Notion',
                'monthly_cost' => 10.00,
                'risk_level' => 'low',
                'website_url' => 'https://www.notion.so',
            ],
            [
                'name' => 'Datadog',
                'monthly_cost' => 100.00,
                'risk_level' => 'high',
                'website_url' => 'https://www.datadoghq.com',
            ],
            [
                'name' => 'Stripe',
                'monthly_cost' => 0.00,
                'risk_level' => 'high',
                'website_url' => 'https://stripe.com',
            ],
        ];

        foreach ($softwares as $software) {
            Software::create($software);
        }
    }
}
