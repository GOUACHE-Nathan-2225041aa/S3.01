<?php
class YoungController
{
    public function execute(): void
    {
        (new YoungView())->show('https://i.kym-cdn.com/news_feeds/icons/mobile/000/035/914/6d3.jpg');
    }
}
