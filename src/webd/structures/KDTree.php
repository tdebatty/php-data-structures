<?php
namespace webd\structures;

class KDTree
{
    /**
     *
     * @var \webd\vectors\Vector 
     */
    public $point;
    
    /**
     *
     * @var KDTree 
     */
    public $left;
    
    /**
     *
     * @var KDTree
     */
    public $right;
    
    
    
    public function __construct(array $points, $depth = 0) {
        if (empty($points)) {
            return ;
        }
        
        $dimension = $points[0]->dim();
        
        // Axis that will be used for splitting
        $axis = $depth % $dimension;
        
        echo "Sort on $axis... ";
        $sort_function = sort_factory($axis);
        // Sort points on choosen axis
        usort($points, $sort_function);
        echo "done\n";
        
        // Choose median point (on choosen axis)
        $median = floor(count($points) / 2);
        
        $this->point = $points[$median];
        
        $this->left = new KDTree(array_slice($points, 0, $median -1), $depth + 1);
        $this->right = new KDTree(array_slice($points, $median +1), $depth + 1);
    }
}

function sort_factory($axis) {
    return function ($a, $b) use ($axis) {
        $a_value = $a->getValue();
        $b_value = $b->getValue();
        return ($a_value[$axis] < $b_value[$axis]) ? -1 : 1;
        //return 1;
    };
}
?>
