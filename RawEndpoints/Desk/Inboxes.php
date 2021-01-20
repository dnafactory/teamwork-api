<?phpcustomers

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Inboxes extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/inboxes/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/inboxes.json', $params);
    }
}
