<?php
namespace webd\structures;

class KDTree
{
    /**
     *
     * @var \webd\vectors\Vector 
     */
    protected $point;
    
    /**
     *
     * @var KDTree 
     */
    protected $left;
    
    /**
     *
     * @var KDTree
     */
    protected $right;
    
    
    
    public function __construct(array $points, $depth = 0) {
        /* @var $points [\webd\vectors\Vector] */
        if (empty($points)) {
            return ;
        }
        
        $dimension = $points[0]->length();
        
        // Axis that will be used for splitting
        $axis = $depth % $dimension;
        
        // Sort points on choosen axis
        $sort_function = self::sort_factory($axis);
        usort($points, $sort_function);
        
        // Choose median point (on choosen axis)
        $median = floor(count($points) / 2);
        $this->point = $points[$median];
        
        $this->left = new KDTree(array_slice($points, 0, $median -1), $depth + 1);
        $this->right = new KDTree(array_slice($points, $median +1), $depth + 1);
    }
    
    public function getPoint() {
        return $this->point;
    }
    
    /**
     * 
     * @return KDTree
     */
    public function getLeft() {
        return $this->left;
    }
    
    public function getRight() {
        return $this->right;
    }
    
    protected static function sort_factory($axis) {
        return function ($a, $b) use ($axis) {
            $a_value = $a->getValue();
            $b_value = $b->getValue();
            return ($a_value[$axis] < $b_value[$axis]) ? -1 : 1;
        };
    }
}


?>
