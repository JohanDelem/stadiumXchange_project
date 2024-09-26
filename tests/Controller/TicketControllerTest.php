<?php

namespace App\Tests\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TicketControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/ticket/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Ticket::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ticket index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ticket[homeTeam]' => 'Testing',
            'ticket[awayTeam]' => 'Testing',
            'ticket[dateTime]' => 'Testing',
            'ticket[price]' => 'Testing',
            'ticket[stadium]' => 'Testing',
            'ticket[state]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ticket();
        $fixture->setHomeTeam('My Title');
        $fixture->setAwayTeam('My Title');
        $fixture->setDateTime('My Title');
        $fixture->setPrice('My Title');
        $fixture->setStadium('My Title');
        $fixture->setState('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ticket');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ticket();
        $fixture->setHomeTeam('Value');
        $fixture->setAwayTeam('Value');
        $fixture->setDateTime('Value');
        $fixture->setPrice('Value');
        $fixture->setStadium('Value');
        $fixture->setState('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ticket[homeTeam]' => 'Something New',
            'ticket[awayTeam]' => 'Something New',
            'ticket[dateTime]' => 'Something New',
            'ticket[price]' => 'Something New',
            'ticket[stadium]' => 'Something New',
            'ticket[state]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ticket/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getHomeTeam());
        self::assertSame('Something New', $fixture[0]->getAwayTeam());
        self::assertSame('Something New', $fixture[0]->getDateTime());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getStadium());
        self::assertSame('Something New', $fixture[0]->getState());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ticket();
        $fixture->setHomeTeam('Value');
        $fixture->setAwayTeam('Value');
        $fixture->setDateTime('Value');
        $fixture->setPrice('Value');
        $fixture->setStadium('Value');
        $fixture->setState('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/ticket/');
        self::assertSame(0, $this->repository->count([]));
    }
}
