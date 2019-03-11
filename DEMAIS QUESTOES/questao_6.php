<?php
class sudoku {
    public function generate(){
        $grid = array(array());
        for($i = 0; $i < 9; $i++){
            for($j = 0; $j < 9; $j++){
                $grid[$i][$j] = ($i*3 + $i/3 + $j) % 9 + 1;
            }
        }
        return $grid;
    }
    
    public function printSudoku ($grid) {
        echo '<table border="1" style="border-spacing: 10px;">';
        for ($row = 0; $row < 9; $row++) {
            echo '<tbody><tr>';
            for ($column = 0; $column < 9; $column++) {
                echo '';
                echo '<td>' . $grid[$row][$column] . '</td>';
            }
            echo '</tr></tbody>';
        }
        echo '</table>';
    }
}
 var_dump(sudoku::printSudoku(sudoku::generate()));
?>