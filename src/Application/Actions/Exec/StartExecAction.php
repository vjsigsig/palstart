<?php declare(strict_types=1);
namespace App\Application\Actions\Exec;

use App\Application\Actions\Action;
use Aws\Credentials\CredentialProvider;
use Aws\Ec2\Ec2Client;

class StartExecAction extends Action
{
    protected function action(): \Psr\Http\Message\ResponseInterface
    {
        $this->logger->info("StartExec action was dispatched");

        $provider = CredentialProvider::ini('default', APP_ROOT . '/credentials.ini');
        $provider = CredentialProvider::memoize($provider);

        $client = new Ec2Client([
            'region' => 'ap-northeast-1',
            'version' => '2016-11-15',
            'credentials' => $provider,
        ]);
        $client->startInstances([
            'InstanceIds' => ['i-0884ac937a752a5f3'],
        ]);

        $this->logger->info("Exec started");

        return $this->respondWithData("サーバー起動したぞ。終わったら止めるの忘れんなよ。");
    }
}
