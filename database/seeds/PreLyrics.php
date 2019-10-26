<?php

use Illuminate\Database\Seeder;

class PreLyrics extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('songs')->insert([[
            'title' => "We Are The Reason",
            'artist' => " Heritage Singers",
            'lyrics' => "As little children
							We would dream of Christmas morn
							Of all the gifts and toys
							We knew we'd find
							But we never realized
							A baby born one blessed night
							Gave us the greatest gift of our lives

							Coro:
							We were the reason
							That He gave His life
							We were the reason
							That He suffered and died
							To a world that was lost
							He gave all He could give
							To show us the reason to live
							As the years went by
							We learned more about gifts
							The giving of ourselves
							And what that means
							On a dark and cloudy day
							A man hung crying in the rain
							All because of love, all because of love
							I've finally found the reason for living
							It's in giving every part of my heart to Him
							In all that I do every word that I say
							I'll be giving my all just for Him, for Him",
		    'belongTo' => 1,
		    'created_at' => date("Y-m-d H:i:s"),
        ],
    	[
            'title' => "Tears in heaven",
            'artist' => "Noel Schajris",
            'lyrics' => "Would you know my name
							If I saw you in Heaven?
							Will you be the same
							If I saw you in Heaven?
							I must be strong
							And carry on
							'Cause I know I don't belong
							Here in Heaven
							Would you hold my hand
							If I saw you in Heaven?
							Would you help me stand
							If I saw you in Heaven?
							I'll find my way
							Through night and day
							'Cause I know I just can't stay
							Here in Heaven
							Time can bring you down
							Time can bend your knees
							Time can break your heart
							Have you begging please
							Begging please
							Beyond the dark
							There's peace
							I'm sure
							And I know there'll be no more
							Tears in Heaven
							Would you know my name
							If I saw you in Heaven?
							Will you be the same
							If I saw you in Heaven?",
		    'belongTo' => 1,
		    'created_at' => date("Y-m-d H:i:s"),
        ]]);
    }
}
