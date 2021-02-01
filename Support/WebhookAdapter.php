<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Endpoints\Router;

class WebhookAdapter
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function adaptTicket(array $rawData)
    {
        $rawTicket = $rawData['ticket'] ?? [];
        $ticketId = $rawTicket['id'];

        $adaptedTicket = [
            'id' => $ticketId,
            'subject' => $rawTicket['subject'],
            'followers' => $rawTicket['followers'],
            'state' => $rawTicket['state'],
            'createdAt' => $rawTicket['createdAt'],
            'updatedAt' => $rawTicket['updatedAt'],
            'customer' => [
                'id' => $rawTicket['customer']['id'],
                'type' => 'customers'
            ],
            'agent' => [
                'id' => $rawTicket['agent']['id'],
                'type' => 'users'
            ],
            'status' => [
                'id' => $rawTicket['status']['id'],
                'type' => 'ticketstatuses'
            ],
            'priority' => [
                'id' => $rawTicket['priority']['id'],
                'type' => 'ticketpriorities'
            ],

        ];

        $customers = [$rawTicket['customer']];
        $users = [$rawTicket['agent']];
        foreach ($rawTicket['threads'] as $thread) {
            if (isset($thread['agent'])) {
                $users[] = $thread['agent'];
            }
            if (isset($thread['customer'])) {
                $customers[] = $thread['customer'];
            }
        }
        $this->router->loadEntries('users', $users);
        $this->router->loadEntries('customers', $customers);
        $this->router->loadEntries('tickets', [$adaptedTicket]);

        return $this->router->retriveReference(['id' => $ticketId, 'type' => 'tickets']);
    }
}
