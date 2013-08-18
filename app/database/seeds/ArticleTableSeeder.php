<?php

class ArticleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('articles')->delete();

        /*
            Assumes:

            "published" has status_id = 1
            "draft" has status_id = 2

            "author" has user_id = 1
         */

        Article::create(array(
            'user_id' => 1,
            'status_id' => 1,
            'title' => 'My first article',
            'slug' => 'my-first-article',
            'excerpt' => 'This is my first article, and here is a short description of it! Tally-ho!',
            'content' => "This will be parsed as markdown and so needs some line-breaks.

## A h2 headline
The content under-which is about the H2 headline, because Google knows everything about SEO and tells you have to build your html.",
        ));

        Article::create(array(
            'user_id' => 1,
            'status_id' => 1,
            'title' => 'My second article',
            'slug' => 'my-second-article',
            'excerpt' => 'This is my second article, and here is a short description of said second article!',
            'content' => "Synth nulla Banksy, sriracha odio ennui forage artisan keytar DIY. Meggings accusamus proident, meh ugh PBR single-origin coffee 3 wolf moon cliche twee dreamcatcher.

## Laborum thundercats gluten-free
Terry Richardson ex semiotics mixtape wolf sunt proident salvia. Church-key Banksy bitters, ex mollit exercitation bicycle rights chambray gluten-free quis aute sriracha forage flexitarian vero.",
        ));

        Article::create(array(
            'user_id' => 1,
            'status_id' => 1,
            'title' => 'My third article',
            'slug' => 'my-third-article',
            'excerpt' => 'This is my third article, and here is a short description of said third article!',
            'content' => "Bacon ipsum dolor sit amet pork belly meatloaf ham hock jerky short ribs pastrami brisket ball tip swine ham fatback capicola spare ribs shank.

## Pancetta short ribs
Pancetta jerky pork loin tenderloin, drumstick strip steak pork belly spare ribs fatback. Strip steak tongue sirloin pancetta tenderloin, ground round fatback sausage. Flank tenderloin beef shank jerky ham chuck jowl chicken. Kielbasa tenderloin beef ribs, capicola ham pancetta turducken shankle filet mignon pork loin.",
        ));

        Article::create(array(
            'user_id' => 1,
            'status_id' => 1,
            'title' => 'My fourth article',
            'slug' => 'my-fourth-article',
            'excerpt' => 'This is my fourth article, and here is a short description of said fourth article!',
            'content' => "Cliche quinoa swag roof party sartorial american apparel. Helvetica Brooklyn chambray PBR, intelligentsia scenester cupidatat 3 wolf moon food truck elit Pinterest ullamco master cleanse.

Meh YOLO put a bird on it velit, minim banh mi non thundercats vegan enim sapiente irure assumenda photo booth. Aute Tonx flannel blog retro McSweeney's. Salvia ennui eu, fingerstache pickled blog twee minim polaroid authentic Brooklyn mixtape.",
        ));

        Article::create(array(
            'user_id' => 1,
            'status_id' => 2,
            'title' => 'My greatest life achievement',
            'slug' => 'my-greatest-life-achievement',
            'excerpt' => "IT'S STILL A DRAFT! I HAVEN'T AHCIEVED ANYTHING!!!! I'VE FAILED AT YOLOING.",
            'content' => "This is the story of a man, who is afraid. But then he just *crushes it* hardcore.",
        ));
    }

}