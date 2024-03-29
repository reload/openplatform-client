<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\SearchResponse;
use LogicException;
use PHPUnit\Framework\TestCase;

class SearchRequestTest extends TestCase
{
    public function testBasicRequest()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $requestData = [
            'q' => 'harry potter',
            'fields' => ['pid', 'title'],
            'offset' => 2,
            'limit' => 50,
            'sort' => SearchRequest::SORT_TITLE,
            'profile' => 'opac',
        ];
        $op->request('/search', $requestData, SearchResponse::class)
            ->willReturn($this->prophesize(SearchResponse::class))
            ->shouldBeCalled();

        $req = (new SearchRequest($op->reveal(), $requestData['q']))
            ->withFields($requestData['fields'])
            ->withOffset($requestData['offset'])
            ->withLimit($requestData['limit'])
            ->withSort($requestData['sort'])
            ->withProfile($requestData['profile']);

        $req->execute();
    }
}
