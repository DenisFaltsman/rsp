<?php

namespace Rusprofile\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class FillUsers extends Command
{
    protected static $defaultName = 'app:seed-users';

    public const RUSPROFILE_URL = 'https://www.rusprofile.ru';

    protected Client $client;

    protected function configure()
    {
        $this->setName('app:seed-users')
            ->setDescription('Seed users table with sample data')
            ->setHelp('Populates users table with test data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Seeding users table...');

        // Можно массово, засорить базу, но не надо
        $response = $this->registerRusprofileUser('Maria Thareva', 'letore2252@ofacer.com', 'asd!DSD@@dsdD');

        $output->writeln($response->getBody());
        $output->writeln('<info>Finished</info>');
        return Command::SUCCESS;
    }


    public function registerRusprofileUser(string $name, string $email, string $password)
    {
        $client = new Client([
            'base_uri' => self::RUSPROFILE_URL,
            'cookies'  => true,
            'headers'  => [
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                'Origin' => self::RUSPROFILE_URL,
                'Referer' => self::RUSPROFILE_URL . '/',
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'X-Csrf-Token' => '208fc4a3d0fece5a9590084b87c038ce::cfac4d8828ea41f19516d4bc864dfab01b76e05c9008bbb47ddd47a56b1df8b0',
            ]
        ]);

        $response = $client->post('/auth.php?action=register&cacheKey=0.8442860567225947', [
            'multipart' => [
                [
                    'name'     => 'name',
                    'contents' => $name,
                ],
                [
                    'name'     => 'login',
                    'contents' => $email,
                ],
                [
                    'name'     => 'password',
                    'contents' => $password,
                ],
            ],
            'headers' => [
                'Cookie' => '_gb_id=8766876170529179524; _ym_uid=1708774496331708423; _ym_d=1708774496; sp=2c7eadd4-0dca-4960-a631-7ac09938bfdb; _clck=24ds0u%7C2%7Cfog%7C0%7C1692; fbb_s=1; email=3wl6d%40punkproof.com; sessid=b74e0a0f63473b29bb9c812050ee6a7d; fbb_u=1733315656; isTouchDevice=0; screenWidth=3440; activeLast=0; activeNow=2024-12-05; _sp_ses.6279=*; __Host-csrf-token=208fc4a3d0fece5a9590084b87c038ce::cfac4d8828ea41f19516d4bc864dfab01b76e05c9008bbb47ddd47a56b1df8b0; _sp_id.6279=f0310f11-0cc7-41d7-b239-9408c536d895.1708774497.7.1733393179.1733315660.a483da42-e64e-461f-a5ee-db5956926c94.d8d50929-6b98-4c3d-842a-dc539b214977.3a4dbdda-5f17-4ab9-9c5b-4d329d3bb9fe.1733393171520.8'
            ]
        ]);

        unset($client);

        return $response;
    }
}
