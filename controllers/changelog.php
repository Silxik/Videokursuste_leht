<?php

class changelog extends Controller
{
    function index()
    {
        // Get changes from Git
        exec("git log --date=iso --pretty=format:'%ad%x08%x08%x08%x08%x08%x08%x08%x08%x08%x08%x08%x08%x08%x08%aN %s'", $output);

        // Process git output
        foreach($output as $row){
            if(substr($row, 0, 4) == '2015'){
                $change = substr($row, 0, 11).substr($row, 25, 999);
                $change = preg_replace('/(^.{10})/',"<b>$1</b>",$change);
//                $change = preg_replace('/(henri\.lindepuu)/', '<span class="badge ">$1</span>', $change);
//                $change = preg_replace('/(Henno Täht)/', '<span class="badge ">$1</span>', $change);
                $this->changes[] = $change;
            }
        }

    }
}