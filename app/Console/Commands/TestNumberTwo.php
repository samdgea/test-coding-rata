<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestNumberTwo extends Command
{
    protected $signature = 'test:two';

    protected $description = 'Test ke dua';

    public function handle()
    {
        $matrix = [];
        $length = $this->ask('Please input length of matrix');
        for($i = 0; $i <= $length-1; $i++) {
            for($j=0 ; $j<$length; $j++){
                $matrix[$i][$j] = $this->ask('Please input the number in matrix on array [' . ($i+1) .'][' . ($j+1) . ']');
            }
        }

        $result=0;
        for($i=0;$i<=count($matrix)-1;$i++){
            $result= $result+($matrix[$i][$i])-($matrix[(count($matrix)-1-$i)] [$i]);
        }


        $this->info('Selisih dari matriks tersebut adalah ' . abs($result)  );
    }
}
