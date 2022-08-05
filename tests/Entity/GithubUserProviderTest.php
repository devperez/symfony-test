<?php

namespace App\Tests\Security;
use App\Entity\User;
use App\Security\GithubUserProvider;
use PHPUnit\Framework\TestCase;

class GithubUserProviderTest extends TestCase
{
    public function testloadUserByUsername()
    {
        $client = $this->getMockBuilder('GuzzleHttp\Client')
                    ->disableOriginalConstructor()
                    ->getMock();
                $serializer = $this
                    ->getMockBuilder('JMS\Serializer\Serializer')
                    ->disableOriginalConstructor()
                    ->getMock();
                    $response = $this
                    ->getMockBuilder('Psr\Http\Message\ResponseInterface')
                    ->getMock();
                $client
                ->expects($this->once())
                ->method('get')
                ->willReturn($response);
                $streamedResponse = $this
                    ->getMockBuilder('Psr\Http\Message\StreamInterface')
                    ->getMock();
                $response
                ->expects($this->once())
                ->method('getBody')
                ->willReturn($streamedResponse);
                
                $userData = ['login' => 'a login', 'name' => 'user name', 'email' => 'adress@mail.com', 'avatar_url' => 'url to the avatar', 'html_url' => 'url to profile'];
                $serializer->method('deserialize')->willReturn($userData);

                $githubUserProvider = new GithubUserProvider($client, $serializer);
                $streamedResponse->method('getContents')->willReturn('foo');
                $user = $githubUserProvider->loadUserByUsername('an-access-token');
    }
}