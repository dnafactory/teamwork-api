<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Messages extends DeskRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $params['filter'] = json_encode(['id' => ['$in' => [$id]]]);
        [$data, $include, $page] = $this->getMany($params);
        return [$data[0], $include, $page];
    }

    public function getMany(array $params)
    {
        $filter = $params['filter'] ?? null;
        if(is_null($filter)){
            throw new \Exception('No filter provided for Messages endpoint, unsupported.');
        }
        $filter = json_decode($filter, JSON_THROW_ON_ERROR, 512);
        $ids = $filter['id']['$in'] ?? null;
        if(is_null($ids)){
            throw new \Exception('Unsupported filter for Messages endpoint.');
        }
        $params['filter'] = json_encode(['messages.id' => ['$in' => $ids]]);

        $includes = explode(',', $params['includes'] ?? '');
        $includes[] = 'messages';
        $params['includes'] = implode(',', array_filter(array_unique($includes)));
        $rawResponse = $this->call("/desk/api/v2/tickets.json", $params);
        $fakeResponse = $this->fakeResponseFromTickets($rawResponse, $ids);
        return $this->extractData($fakeResponse, 'messages');
    }

    public function fakeResponseFromTickets($rawResponse, $ids)
    {
        $ids = array_combine($ids, $ids);
        $messages = $included = [];
        $allMessages = $rawResponse['included']['messages'] ?? [];
        foreach($allMessages as $i => $message) {
            $id = $message['id'] ?? null;
            if(isset($ids[$id])){
                $messages[] = $message;
                unset($allMessages[$i]);
            }
        }

        $included = $rawResponse['included'];
        $included['tickets'] = $rawResponse['tickets'] ?? [];
        $included['messages'] = array_values($allMessages);
        return [
            'messages' => $messages,
            'included' => $included,
            'meta' => $rawResponse['meta']
        ];
    }
}
