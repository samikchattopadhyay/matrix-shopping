<?php

class CategoryModel extends Model
{
    // initialize properties
    private $properties = array(
        
        'table_name' => 'categories',
        'id_column' => 'id',
        'title_column' => 'name',
        'left_column' => 'lft',
        'right_column' => 'rgt',
        'parent_column' => 'pid'
    
    );

    /**
     * Adds a new node as the child of a given parent node.
     *
     * <code>
     * // add a new topmost node
     * $node = $mptt->add(0, 'Main');
     *
     * // add a child node
     * $mptt->add($node, 'Child 1');
     *
     * // add another child node
     * $mptt->add($node, 'Child 2');
     *
     * // insert a third child node
     * // notice the "1" as the last argument, instructing the script to insert the child node
     * // as the second child node, after "Child 1"
     * // remember that the trees are 0-based, meaning that the first node in a tree has the index 0!
     * $mptt->add($node, 'Child 3', 1);
     *
     * // and finally, insert a fourth child node
     * // notice the "0" as the last argument, instructing the script to insert the child node
     * // as the very first child node of the parent node
     * // remember that the trees are 0-based, meaning that the first node in a tree has the index 0!
     * $mptt->add($node, 'Child 4', 0);
     * </code>
     *
     * @param integer $parent
     *            The ID of the parent node.
     *            
     *            Use "0" to add a topmost node.
     *            
     * @param string $title
     *            The title of the node.
     *            
     * @param integer $position
     *            (Optional) The position the node will have among the parent node's children nodes.
     *            
     *            When parent node is given as "0", this refers to the position the node will have
     *            among the topmost nodes.
     *            
     *            The values are 0-based, meaning that if you want the node to be inserted as
     *            the first child of the target node, you have to use "0", if you want it to
     *            be second, use "1", and so on.
     *            
     *            If not given (or given as boolean FALSE), the node will be inserted as the last
     *            of the parent node's children nodes.
     *            
     * @return mixed Returns the ID of the newly inserted node or FALSE on error.
     */
    public function add($parent, $title, $position = false, $extraDetails = array())
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // make sure parent ID is an integer
        $parent = (int) $parent;
        
        // continue only if
        if (
        
        // we are adding a topmost node OR
        $parent == 0 || 
        
        // parent node exists in the lookup array
        isset($this->lookup[$parent])) 
        {
            
            // get parent's descendant nodes (no deeper than the first level)
            $descendants = $this->get_descendants($parent);
            
            // if node is to be inserted in the default position (as the last of the parent node's children)
            // give a numerical value to the position
            if ($position === false)
                $position = count($descendants);
            
            // if a custom position was specified
            else {
                
                // make sure that position is an integer value
                $position = (int) $position;
                
                // if position is a bogus number
                // use the default position (as the last of the parent node's children)
                if ($position > count($descendants) || $position < 0)
                    $position = count($descendants);
            }
            
            // if parent has no descendants OR the node is to be inserted as the parent node's first child
            if (empty($descendants) || $position == 0)
                
                // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
                // the insert, and will need to be updated
                // if parent is not found (meaning that we're inserting a topmost node) set the boundary to 0
                $boundary = isset($this->lookup[$parent]) ? $this->lookup[$parent][$this->properties['left_column']] : 0;
            
            // if parent node has descendant nodes and/or the node needs to be inserted at a specific position
            else {
                
                // find the child node that currently exists at the position where the new node needs to be inserted to
                $slice = array_slice($descendants, $position - 1, 1);
                
                $descendants = array_shift($slice);
                
                // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
                // the insert, and will need to be updated
                $boundary = $descendants[$this->properties['right_column']];
            }
            
            // iterate through all the records in the lookup array
            foreach ($this->lookup as $id => $properties) {
                
                // if the node's "left" value is outside the boundary
                if ($properties[$this->properties['left_column']] > $boundary)
                    
                    // increment it with 2
                    $this->lookup[$id][$this->properties['left_column']] += 2;
                
                // if the node's "right" value is outside the boundary
                if ($properties[$this->properties['right_column']] > $boundary)
                    
                    // increment it with 2
                    $this->lookup[$id][$this->properties['right_column']] += 2;
            }
            
            // lock table to prevent other sessions from modifying the data and thus preserving data integrity
            $this->database->query('LOCK TABLE `' . $this->properties['table_name'] . '` WRITE');
            
            // update the nodes in the database having their "left"/"right" values outside the boundary
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = `' . $this->properties['left_column'] . '` + 2
                WHERE
                    `' . $this->properties['left_column'] . '` > ' . $boundary . '
                    
            ');
            
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['right_column'] . '` = `' . $this->properties['right_column'] . '` + 2
                WHERE
                    `' . $this->properties['right_column'] . '` > ' . $boundary . '
                    
            ');
            
            // insert the new node into the database
            $this->database->query('
                INSERT INTO
                    `' . $this->properties['table_name'] . '`
                    (
                        `' . $this->properties['title_column'] . '`,
                        `' . $this->properties['left_column'] . '`,
                        `' . $this->properties['right_column'] . '`,
                        `' . $this->properties['parent_column'] . '`
                    )
                VALUES
                    (
                        "' . $title . '",
                        ' . ($boundary + 1) . ',
                        ' . ($boundary + 2) . ',
                        ' . $parent . '
                    )
            ');
            
            // get the ID of the newly inserted node
            $node_id = $this->database->getInsertId();
            
            // release table lock
            $this->database->query('UNLOCK TABLES');
            
            // add the node to the lookup array
            $this->lookup[$node_id] = array(
                $this->properties['id_column'] => $node_id,
                $this->properties['title_column'] => $title,
                $this->properties['left_column'] => $boundary + 1,
                $this->properties['right_column'] => $boundary + 2,
                $this->properties['parent_column'] => $parent
            );
            
            // reorder the lookup array
            $this->_reorder_lookup_array();
            
            // Update those extra details
            $this->updateById($node_id, $extraDetails);
            
            // return the ID of the newly inserted node
            return $node_id;
        }
        
        // if script gets this far, something must've went wrong so we return false
        return false;
    }

    /**
     * Deletes a node, including the node's descendant nodes.
     *
     * <code>
     * // add a topmost node
     * $node = $mptt->add(0, 'Main');
     *
     * // add child node
     * $child1 = $mptt->add($node, 'Child 1');
     *
     * // add another child node
     * $child2 = $mptt->add($node, 'Child 2');
     *
     * // delete the "Child 2" node
     * $mptt->delete($child2);
     * </code>
     *
     * @param integer $node
     *            The ID of the node to delete.
     *            
     * @return boolean TRUE on success or FALSE on error.
     */
    public function delete($node)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // continue only if target node exists in the lookup array
        if (isset($this->lookup[$node])) {
            
            // get target node's descendant nodes (if any)
            $descendants = $this->get_descendants($node, false);
            
            // iterate through target node's descendant nodes
            foreach ($descendants as $descendant)
                
                // remove node from the lookup array
                unset($this->lookup[$descendant[$this->properties['id_column']]]);
            
            // lock table to prevent other sessions from modifying the data and thus preserving data integrity
            $this->database->query('LOCK TABLE `' . $this->properties['table_name'] . '` WRITE');
            
            // also remove nodes from the database
            $this->database->query('
                    
                DELETE
                FROM
                    `' . $this->properties['table_name'] . '`
                WHERE
                    `' . $this->properties['left_column'] . '` >= ' . $this->lookup[$node][$this->properties['left_column']] . ' AND
                    `' . $this->properties['right_column'] . '` <= ' . $this->lookup[$node][$this->properties['right_column']] . '
                    
            ');
            
            // the value with which items outside the boundary set below, are to be updated with
            $target_rl_difference = $this->lookup[$node][$this->properties['right_column']] - $this->lookup[$node][$this->properties['left_column']] + 1;
            
            // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
            // the insert, and will need to be updated
            $boundary = $this->lookup[$node][$this->properties['left_column']];
            
            // remove the target node from the lookup array
            unset($this->lookup[$node]);
            
            // iterate through nodes in the lookup array
            foreach ($this->lookup as $id => $properties) {
                
                // if the "left" value of node is outside the boundary
                if ($this->lookup[$id][$this->properties['left_column']] > $boundary)
                    
                    // decrement it
                    $this->lookup[$id][$this->properties['left_column']] -= $target_rl_difference;
                
                // if the "right" value of node is outside the boundary
                if ($this->lookup[$id][$this->properties['right_column']] > $boundary)
                    
                    // decrement it
                    $this->lookup[$id][$this->properties['right_column']] -= $target_rl_difference;
            }
            
            // update the nodes in the database having their "left"/"right" values outside the boundary
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = `' . $this->properties['left_column'] . '` - ' . $target_rl_difference . '
                WHERE
                    `' . $this->properties['left_column'] . '` > ' . $boundary . '
                    
            ');
            
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['right_column'] . '` = `' . $this->properties['right_column'] . '` - ' . $target_rl_difference . '
                WHERE
                    `' . $this->properties['right_column'] . '` > ' . $boundary . '
                    
            ');
            
            // release table lock
            $this->database->query('UNLOCK TABLES');
            
            // return true as everything went well
            return true;
        }
        
        // if script gets this far, something must've went wrong so we return false
        return false;
    }

    /**
     * Returns an unidimensional (flat) array with the descendant nodes of a given parent node.
     *
     * <i>For a multidimensional array use the {@link get_tree()} method.</i>
     *
     * @param integer $node
     *            (Optional) The ID of a node for which to return the descendant nodes.
     *            
     *            When not specified or given as "0", the "root" node is implied.
     *            
     * @param boolean $direct_descendants_only
     *            (Optional) Set this to FALSE if you want <b>all the descendants</b>
     *            (including descendants of descendants), and not just the <b>direct
     *            descendants</b> (children) of the node.
     *            
     *            Default is TRUE
     *            
     * @return array Returns an unidimensional array with the descendant nodes of a
     *         given parent node.
     */
    public function get_descendants($node = 0, $direct_descendants_only = true)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // if parent node exists in the lookup array OR we're looking for the topmost nodes
        if (isset($this->lookup[$node]) || $node === 0) {
            
            $descendants = array();
            
            // get the keys in the lookup array
            $keys = array_keys($this->lookup);
            
            // iterate through the available keys
            foreach ($keys as $item)
                
                // if
                if (
                
                // node's "left" is higher than parent node's "left" (or, if parent is 0, if it is higher than 0)
                $this->lookup[$item][$this->properties['left_column']] > ($node !== 0 ? $this->lookup[$node][$this->properties['left_column']] : 0) && 
                
                // node's "left" is smaller than parent node's "right" (or, if parent is 0, if it is smaller than PHP's maximum integer value)
                $this->lookup[$item][$this->properties['left_column']] < ($node !== 0 ? $this->lookup[$node][$this->properties['right_column']] : PHP_INT_MAX) && 
                
                // if we only need the first level children, check if children node's parent node is the parent given as argument
                (! $direct_descendants_only || $this->lookup[$item][$this->properties['parent_column']] == $node))
                    
                    // save to array
                    $descendants[$this->lookup[$item][$this->properties['id_column']]] = $this->lookup[$item];
            
            // return children nodes
            return $descendants;
        }
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns the number of descendant nodes of a given node.
     *
     * @param integer $node
     *            The ID of the node for which to return the number of direct
     *            descendant nodes.
     *            
     * @param boolean $direct_descendants_only
     *            (Optional) Specifies whether to count <b>direct descendants only</b>,
     *            or to count <b>all the descendants</b> (including descendants of
     *            descendants)
     *            
     *            Default is TRUE
     *            
     * @return integer Returns the number of direct descendant nodes of a parent node,
     *         or FALSE on error.
     *        
     *         <i>Since this method may return both "0" and FALSE, make sure you
     *         use === to verify the returned result!</i>
     */
    public function get_descendant_count($node, $direct_descendants_only = true)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // if parent node exists in the lookup array
        if (isset($this->lookup[$node]))
            
            // if we require all the descendants (not direct only)
            if (! $direct_descendants_only)
                
                // return the total number of descendant nodes
                return ($this->lookup[$node][$this->properties['right_column']] - $this->lookup[$node][$this->properties['left_column']] - 1) / 2;
            
            // if we require direct descendants only
            else {
                
                $result = 0;
                
                // iterate through all the records in the lookup array
                foreach ($this->lookup as $id => $properties)
                    
                    // if node is a direct descendant of the parent node
                    if ($this->lookup[$id][$this->properties['parent_column']] == $node)
                        
                        // increment the number of direct descendant nodes
                        $result ++;
                
                // return the number of direct descendant nodes
                return $result;
            }
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns the next sibling of a node.
     *
     * @param integer $node
     *            The ID of a node for which to return the next sibling node.
     *            
     * @return mixed Returns a node's next sibling node, "0" if a next sibling doesn't exist, or
     *         FALSE on error (if the node doesn't exist).
     *        
     *         <i>Since this method may return both "0" and FALSE, make sure you use === to
     *         verify the returned result!</i>
     *        
     * @since 2.2.6
     */
    public function get_next_sibling($node)
    {
        
        // if node exists, get its siblings
        // (if $node exists this will never be an empty array as it will contain at least $node)
        if ($siblings = $this->get_siblings($node, true)) {
            
            // get the node's position among the siblings
            $node_position = array_search($node, array_keys($siblings));
            
            // get next node
            $sibling = array_slice($siblings, $node_position + 1, 1);
            
            // return result
            return ! empty($sibling) ? array_pop($sibling) : 0;
        }
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns an array containing a node's direct parent node if the node has a parent node, or "0" if the node is a
     * topmost node.
     *
     * @param integer $node
     *            The ID of a node for which to return the parent node.
     *            
     * @return mixed Returns an array containing a node's direct parent node if the node has a
     *         parent node, or "0" if the node is a topmost node.
     *        
     *         <i>Since this method may return both "0" and FALSE, make sure you use ===
     *         to verify the returned result!</>
     */
    public function get_parent($node)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // if node exists in the lookup array
        if (isset($this->lookup[$node]))
            
            // if node has a parent node, return the parent node's properties
            // also, return 0 if the node is a topmost node
            return isset($this->lookup[$this->lookup[$node][$this->properties['parent_column']]]) ? $this->lookup[$this->lookup[$node][$this->properties['parent_column']]] : 0;
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns an unidimensional (flat) array with the path to the given node (including the node itself).
     *
     * @param integer $node
     *            The ID of a node for which to return the path.
     *            
     * @return array Returns an unidimensional array with the path to the given node.
     */
    public function get_path($node)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        $parents = array();
        
        // if node exists in the lookup array
        if (isset($this->lookup[$node]))
            
            // iterate through all the nodes in the lookup array
            foreach ($this->lookup as $id => $properties)
                
                // if
                if (
                
                // node is a parent node
                $properties[$this->properties['left_column']] < $this->lookup[$node][$this->properties['left_column']] && 
                $properties[$this->properties['right_column']] > $this->lookup[$node][$this->properties['right_column']])
                    
                    // save the parent node's information
                    $parents[$properties[$this->properties['id_column']]] = $properties;
        
        // add also the node given as argument
        $parents[$node] = $this->lookup[$node];
        
        // return the path to the node
        return $parents;
    }

    /**
     * Returns the previous sibling of a node.
     *
     * @param integer $node
     *            The ID of a node for which to return the previous sibling node.
     *            
     * @return mixed Returns a node's previous sibling node, "0" if a previous sibling doesn't
     *         exist, or FALSE on error (if the node doesn't exist).
     *        
     *         <i>Since this method may return both "0" and FALSE, make sure you use === to
     *         verify the returned result!</i>
     *        
     * @since 2.2.6
     */
    public function get_previous_sibling($node)
    {
        
        // if node exists, get its siblings
        // (if $node exists this will never be an empty array as it will contain at least $node)
        if ($siblings = $this->get_siblings($node, true)) {
            
            // get the node's position among the siblings
            $node_position = array_search($node, array_keys($siblings));
            
            // get previous node
            $sibling = $node_position > 0 ? array_slice($siblings, $node_position - 1, 1) : array();
            
            // return result
            return ! empty($sibling) ? array_pop($sibling) : 0;
        }
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns an array with a node's sibling nodes.
     *
     * @param integer $node
     *            The ID of a node for which to return the node's sibling nodes.
     *            
     * @param boolean $include_self
     *            Whether the node given as argument should also be present in the returned
     *            array.
     *            
     * @return mixed Returns an array with a node's sibling nodes, an empty array if the node has
     *         no siblings, or FALSE on error (if the node doesn't exist)
     *        
     * @since 2.2.6
     */
    public function get_siblings($node, $include_self = false)
    {
        
        // if parent node exists in the lookup array OR we're looking for the topmost nodes
        if (isset($this->lookup[$node])) {
            
            // properties of the node
            $properties = $this->lookup[$node];
            
            // get node's siblings
            $siblings = $this->get_descendants($properties['parent']);
            
            // remove self, if required so
            if (! $include_self)
                unset($siblings[$node]);
            
            // return siblings
            return $siblings;
        }
        
        // if script gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns a multidimensional array with all the descendant nodes (including children nodes of children nodes of
     * children nodes and so on) of a given node.
     *
     * @param integer $node
     *            (Optional) The ID of a node for which to return all descendant nodes, as
     *            a multidimensional array.
     *            
     *            Not given or given as "0", will return all the nodes.
     *            
     * @return array Returns a multi dimensional array with all the descendant nodes (including
     *         children nodes of children nodes of children nodes and so on) of a given
     *         node.
     */
    public function get_tree($node = 0)
    {
        
        // get direct children nodes
        $descendants = $this->get_descendants($node);
        
        // iterate through the direct children nodes
        foreach ($descendants as $id => $properties)
            
            // for each child node create a "children" property
            // and get the node's children nodes, recursively
            $descendants[$id]['children'] = $this->get_tree($id);
        
        // return the array
        return $descendants;
    }

    /**
     * Moves a node, including the node's descendants nodes, into another node (becoming that node's child), or
     * after/before a node (becoming that node's sibling)
     *
     * <code>
     * // insert a topmost node
     * $node = $mptt->add(0, 'Main');
     *
     * // add a child node
     * $child1 = $mptt->add($node, 'Child 1');
     *
     * // add another child node
     * $child2 = $mptt->add($node, 'Child 2');
     *
     * // add another child node
     * $child3 = $mptt->add($node, 'Child 3');
     *
     * // move "Child 2" node to be the first of "Main"'s children nodes
     * $mptt->move($child2, $node, 0);
     *
     * // move "Child 2" node into "Child 1"
     * $mptt->move($child2, $child1);
     *
     * // move "Child 1" after "Child 3"
     * $mptt->move($child1, $child3, 'after');
     * </code>
     *
     * @param integer $source
     *            The ID of a node to move
     *            
     * @param integer $target
     *            The ID of the node relative to which the source node needs to be moved. Use
     *            "0" if the node does not need a parent node (making it a topmost node).
     *            
     * @param integer $position
     *            (Optional) The position where to move the node, relative to the target node.
     *            
     *            Can be a numerical value, indicating that the source node needs to be moved to
     *            become a <b>child of the target node</b>, inserted at the indicated position (
     *            the values are 0-based, meaning that if you want the node to be inserted as
     *            the first child of the target node, you have to use "0", if you want it to
     *            be second, use "1", and so on)
     *            
     *            Can also be the literal "after" or "before" string, indicating the the source
     *            node needs to be moved <b>after/before the target node</b>.
     *            
     *            If not given (or given as boolean FALSE), the node will be inserted as the last
     *            of the target node's children nodes.
     *            
     * @return boolean TRUE on success or FALSE on error
     */
    public function move($source, $target, $position = false)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // continue only if
        if (
        
        // source node exists in the lookup array AND
        isset($this->lookup[$source]) && 
        
        // target node exists in the lookup array OR is 0 (indicating a topmost node)
        (isset($this->lookup[$target]) || $target == 0) && 
        
        // target node is not a child node of the source node (that would cause infinite loop)
        ! in_array($target, array_keys($this->get_descendants($source, false)))) 
        {
            
            // if we have to move the node after/before another node
            if ($position === 'after' || $position === 'before') {
                
                // get the target's parent node
                $target_parent = $target == 0 ? 0 : $this->lookup[$target]['parent'];
                
                // get the target's parent's descendant nodes
                $descendants = $this->get_descendants($target_parent);
                
                // get the target's position among the descendants
                $keys = array_keys($descendants);
                $target_position = array_search($target, $keys);
                
                // move the source node to the desired position
                if ($position == 'after')
                    return $this->move($source, $target_parent, $target_position + 1);
                else
                    return $this->move($source, $target_parent, $target_position == 0 ? 0 : $target_position - 1);
            }
            
            // the source's parent node's ID becomes the target node's ID
            $this->lookup[$source][$this->properties['parent_column']] = $target;
            
            // get source node's descendant nodes (if any)
            $source_descendants = $this->get_descendants($source, false);
            
            // this array will hold the nodes we need to move
            // by default we add the source node to it
            $sources = array(
                $this->lookup[$source]
            );
            
            // iterate through source node's descendants
            foreach ($source_descendants as $descendant) {
                
                // save them for later use
                $sources[] = $this->lookup[$descendant[$this->properties['id_column']]];
                
                // for now, remove them from the lookup array
                unset($this->lookup[$descendant[$this->properties['id_column']]]);
            }
            
            // the value with which nodes outside the boundary set below, are to be updated with
            $source_rl_difference = 
            $this->lookup[$source][$this->properties['right_column']] - 
            $this->lookup[$source][$this->properties['left_column']] + 
            1;
            
            // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
            // the insert, and will need to be updated
            $source_boundary = $this->lookup[$source][$this->properties['left_column']];
            
            // lock table to prevent other sessions from modifying the data and thus preserving data integrity
            $this->database->query('LOCK TABLE `' . $this->properties['table_name'] . '` WRITE');
            
            // we'll multiply the "left" and "right" values of the nodes we're about to move with "-1", in order to
            // prevent the values being changed further in the script
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = `' . $this->properties['left_column'] . '` * -1,
                    `' . $this->properties['right_column'] . '` = `' . $this->properties['right_column'] . '` * -1
                WHERE
                    `' . $this->properties['left_column'] . '` >= ' . $this->lookup[$source][$this->properties['left_column']] . ' AND
                    `' . $this->properties['right_column'] . '` <= ' . $this->lookup[$source][$this->properties['right_column']] . '
                    
            ');
            
            // remove the source node from the list
            unset($this->lookup[$source]);
            
            // iterate through the remaining nodes in the lookup array
            foreach ($this->lookup as $id => $properties) {
                
                // if the "left" value of node is outside the boundary
                if ($this->lookup[$id][$this->properties['left_column']] > $source_boundary)
                    
                    // decrement it
                    $this->lookup[$id][$this->properties['left_column']] -= $source_rl_difference;
                
                // if the "right" value of item is outside the boundary
                if ($this->lookup[$id][$this->properties['right_column']] > $source_boundary)
                    
                    // decrement it
                    $this->lookup[$id][$this->properties['right_column']] -= $source_rl_difference;
            }
            
            // update the nodes in the database having their "left"/"right" values outside the boundary
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = `' . $this->properties['left_column'] . '` - ' . $source_rl_difference . '
                WHERE
                    `' . $this->properties['left_column'] . '` > ' . $source_boundary . '
                    
            ');
            
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['right_column'] . '` = `' . $this->properties['right_column'] . '` - ' . $source_rl_difference . '
                WHERE
                    `' . $this->properties['right_column'] . '` > ' . $source_boundary . '
                    
            ');
            
            // get descendant nodes of target node (first level only)
            $target_descendants = $this->get_descendants((int) $target);
            
            // if node is to be inserted in the default position (as the last of target node's children nodes)
            // give a numerical value to the position
            if ($position === false)
                $position = count($target_descendants);
            
            // if a custom position was specified
            else {
                
                // make sure given position is an integer value
                $position = (int) $position;
                
                // if position is a bogus number
                if ($position > count($target_descendants) || $position < 0)
                    
                    // use the default position (as the last of the target node's children)
                    $position = count($target_descendants);
            }
            
            // because of the insert, some nodes need to have their "left" and/or "right" values adjusted
            
            // if target node has no descendant nodes OR the node is to be inserted as the target node's first child node
            if (empty($target_descendants) || $position == 0)
                
                // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
                // the insert, and will need to be updated
                // if parent is not found (meaning that we're inserting a topmost node) set the boundary to 0
                $target_boundary = isset($this->lookup[$target]) ? $this->lookup[$target][$this->properties['left_column']] : 0;
            
            // if target has any descendant nodes and/or the node needs to be inserted at a specific position
            else {
                
                // find the target's child node that currently exists at the position where the new node needs to be inserted to
                $slice = array_slice($target_descendants, $position - 1, 1);
                
                $target_descendants = array_shift($slice);
                
                // set the boundary - nodes having their "left"/"right" values outside this boundary will be affected by
                // the insert, and will need to be updated
                $target_boundary = $target_descendants[$this->properties['right_column']];
            }
            
            // iterate through the records in the lookup array
            foreach ($this->lookup as $id => $properties) {
                
                // if the "left" value of node is outside the boundary
                if ($properties[$this->properties['left_column']] > $target_boundary)
                    
                    // increment it
                    $this->lookup[$id][$this->properties['left_column']] += $source_rl_difference;
                
                // if the "left" value of node is outside the boundary
                if ($properties[$this->properties['right_column']] > $target_boundary)
                    
                    // increment it
                    $this->lookup[$id][$this->properties['right_column']] += $source_rl_difference;
            }
            
            // update the nodes in the database having their "left"/"right" values outside the boundary
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = `' . $this->properties['left_column'] . '` + ' . $source_rl_difference . '
                WHERE
                    `' . $this->properties['left_column'] . '` > ' . $target_boundary . '
                    
            ');
            
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['right_column'] . '` = `' . $this->properties['right_column'] . '` + ' . $source_rl_difference . '
                WHERE
                    `' . $this->properties['right_column'] . '` > ' . $target_boundary . '
                    
            ');
            
            // finally, the nodes that are to be inserted need to have their "left" and "right" values updated
            $shift = $target_boundary - $source_boundary + 1;
            
            // iterate through the nodes to be inserted
            foreach ($sources as $properties) {
                
                // update "left" value
                $properties[$this->properties['left_column']] += $shift;
                
                // update "right" value
                $properties[$this->properties['right_column']] += $shift;
                
                // add the item to our lookup array
                $this->lookup[$properties[$this->properties['id_column']]] = $properties;
            }
            
            // also update the entries in the database
            // (notice that we're subtracting rather than adding and that finally we multiply by -1 so that the values
            // turn positive again)
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['left_column'] . '` = (`' . $this->properties['left_column'] . '` - ' . $shift . ') * -1,
                    `' . $this->properties['right_column'] . '` = (`' . $this->properties['right_column'] . '` - ' . $shift . ') * -1
                WHERE
                    `' . $this->properties['left_column'] . '` < 0
                    
            ');
            
            // finally, update the parent of the source node
            $this->database->query('
                    
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['parent_column'] . '` = ' . $target . '
                WHERE
                    `' . $this->properties['id_column'] . '` = ' . $source . '
                    
            ');
            
            // release table lock
            $this->database->query('UNLOCK TABLES');
            
            // reorder the lookup array
            $this->_reorder_lookup_array();
            
            // return true as everything went well
            return true;
        }
        
        // if scripts gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Updates a node's title.
     *
     * <code>
     * // add a topmost node
     * $node = $mptt->add(0, 'Main');
     *
     * // change the node's title
     * $mptt->update($node, 'Primary');
     * </code>
     *
     * @param integer $node
     *            The ID of a node to update the title for.
     *            
     * @param string $title
     *            The new title to be set for the node.
     *            
     * @return boolean TRUE on success or FALSE on error.
     *        
     * @since 2.2.5
     */
    public function update($node, $title, $extraData = array())
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // continue only if target node exists in the lookup array
        if (isset($this->lookup[$node])) {
            
            // lock table to prevent other sessions from modifying the data and thus preserving data integrity
            $this->database->query('LOCK TABLE `' . $this->properties['table_name'] . '` WRITE');
            
            // update node's title
            $this->database->query('
                
                UPDATE
                    `' . $this->properties['table_name'] . '`
                SET
                    `' . $this->properties['title_column'] . '` = "' . $title . '"
                WHERE
                    `' . $this->properties['id_column'] . '` = ' . $node . '
                
            ');
            
            // release table lock
            $this->database->query('UNLOCK TABLES');
            
            // update lookup array
            $this->lookup[$node][$this->properties['title_column']] = $title;
            
            // Update those extra data
            $this->updateById($node, $extraData);
            
            // return true as everything went well
            return true;
        }
        
        // if scripts gets this far, return false as something must've went wrong
        return false;
    }

    /**
     * Returns an unidimensional (flat) array with the descendant nodes of the node given as argument, indented using
     * whatever given in the <i>$separator</i> argument, and ready to be used in a <select> element.
     *
     * <code>
     * $selectables = $mptt->get_selectables($node_id);
     *
     * echo '<select name="myselect">';
     *
     * foreach ($selectables as $value => $caption)
     *
     * echo '<option value="' . $value . '">' . $caption . '</option>';
     *
     * echo '</select>';
     * </code>
     *
     * @param integer $node
     *            (Optional) The ID of a node for which to get the descendant nodes and return
     *            everything as a unidimensional (flat) array, indented using whatever given in the
     *            <i>$separator</i> argument, and ready to be used in a <select> control.
     *            
     *            When not given, or given as "0", will return an array with *all* the available
     *            nodes.
     *            
     * @param string $separator
     *            (Optional) A string to indent the nodes by.
     *            
     *            Default is " &rarr; "
     *            
     * @return array Returns an array of children nodes of a node given as argument, indented and ready
     *         to be used in a <select> control.
     */
    public function to_select($node = 0, $separator = ' &rarr; ')
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // continue only if parent node exists in the lookup array OR is 0 (indicating topmost node)
        if (isset($this->lookup[$node]) || $node == 0) {
            
            // the resulting array and a temporary array
            $result = $parents = array();
            
            // get node's descendant nodes
            $descendants = $this->get_descendants($node, false);
            
            // if node is not 0, prepend the item itself to the list
            if ($node != 0)
                array_unshift($descendants, $this->lookup[$node]);
            
            // iterate through the nodes
            foreach ($descendants as $properties) {
                
                // if we find a topmost node
                if ($properties[$this->properties['parent_column']] == 0) {
                    
                    // if the $nodes variable is set, save the what we have so far
                    if (isset($nodes))
                        $result += $nodes;
                    
                    // reset the categories and parents arrays
                    $nodes = $parents = array();
                }
                
                // if the node has any parents
                if (count($parents) > 0) {
                    
                    $keys = array_keys($parents);
                    
                    // iterate through the array of parent nodes
                    while (array_pop($keys) < $properties[$this->properties['right_column']])
                        
                        // and remove parents that are not parents of current node
                        array_pop($parents);
                }
                
                // add node to the stack of nodes
                $nodes[$properties[$this->properties['id_column']]] = (! empty($parents) ? str_repeat($separator, count($parents)) : '') . $properties[$this->properties['title_column']];
                
                // add node to the stack of parents
                $parents[$properties[$this->properties['right_column']]] = $properties[$this->properties['title_column']];
            }
            
            // may not be set when there are no nodes at all
            // finalize the result
            if (isset($nodes))
                $result += $nodes;
            
            // return the resulting array
            return $result;
        }
        
        // if the script gets this far, return false as something must've went wrong
        return false;
    }
    
    
     
    /**
     * Transforms a node and it's subnodes to an ordered/unordered list.
     *
     * The list items will have the class attribute set to "zebra_mptt_item zebra_mptt_item_xx" where "xx" is the ID
     * of the respective node.
     *
     * <i>You can further customize the output with regular expressions to suit your needs</i>
     *
     * <code>
     * // instantiate the class
     * $mptt = new Zebra_Mptt();
     *
     * // make a list out of all nodes as an ordered list and with the
     * // main list having the class "mylist"
     * echo $mptt->to_list(0, 'ol', 'class="mylist"');
     * </code>
     *
     * @param integer $node
     *            The ID of a node.
     *            
     *            When given as "0", the "root" node is implied.
     *            
     * @param string $list_type
     *            (Optional) Can be either "ul" (for an unordered list) or "ol" (for an ordered
     *            list).
     *            
     *            Default is "ul".
     *            
     * @param string $attributes
     *            Additional HTML attributes to set for the main list, like "class" or "style".
     *            
     * @return string
     *
     * @since 2.2.3
     */
    public function to_list($node, $list_type = 'ul', $attributes = '')
    {
        
        // if node is an ID, get the descendant nodes
        // (when called recursively this is an array)
        if (! is_array($node))
            $node = $this->get_tree($node);
        
        // if there are any elements
        if (! empty($node)) {
            
            // start generating the output
            $out = '<' . $list_type . ($attributes != '' ? ' ' . $attributes : '') . '>';
            
            // iterate through each node
            foreach ($node as $elem)
                
                // generate output and if the node has children nodes, call this method recursively
                $out .= '<li class="zebra_mptt_item zebra_mptt_item_' . $elem[$this->properties['id_column']] . '">' . $elem[$this->properties['title_column']] . (is_array($elem['children']) ? $this->to_list($elem['children'], $list_type) : '') . '</li>';
            
            // return generated output
            return $out . '</' . $list_type . '>';
        }
    }

    /**
     * Reads the data from the MySQL table and creates a lookup array.
     * Searches will be done in the lookup array
     * rather than always querying the database.
     *
     * @return void
     *
     * @access private
     */
    private function _init()
    {
        
        // if the results are not already cached
        if (! isset($this->lookup)) {
            
            // fetch data from the database
            $result = $this->database->query('
                 
                SELECT
                    *
                FROM
                    `' . $this->properties['table_name'] . '`
                ORDER BY
                    `' . $this->properties['left_column'] . '`
                 
            ');
            
            $this->lookup = array();
            
            $records = $result->fetchAll();
            
            // iterate through the found records
            foreach ($records as $row)
                
                // put all records in an array; use the ID column as index
                $this->lookup[$row[$this->properties['id_column']]] = (array) $row;
        }
    }

    /**
     * Updates the lookup array after inserts and deletes.
     *
     * @return void
     *
     * @access private
     */
    private function _reorder_lookup_array()
    {
        
        // reorder the lookup array
        
        // iterate through the nodes in the lookup array
        foreach ($this->lookup as $properties)
            
            // create a new array with the name of "left" column, having the values from the "left" column
            ${$this->properties['left_column']}[] = $properties[$this->properties['left_column']];
        
        // order the array by the left column
        // in the ordering process, the keys are lost
        array_multisort(${$this->properties['left_column']}, SORT_ASC, $this->lookup);
        
        $tmp = array();
        
        // iterate through the existing nodes
        foreach ($this->lookup as $properties)
            
            // and save them to a different array, this time with the correct ID
            $tmp[$properties[$this->properties['id_column']]] = $properties;
        
        // the updated lookup array
        $this->lookup = $tmp;
        
        // free memory
        unset($tmp);
    }


    
    public function get_details ($node)
    {
        
        // lazy connection: touch the database only when the data is required for the first time and not at object instantiation
        $this->_init();
        
        // if node exists in the lookup array
        if (isset($this->lookup[$node]))
            
            // if node has a parent node, return the parent node's properties
            // also, return 0 if the node is a topmost node
            return isset($this->lookup[$this->lookup[$node][$this->properties['id_column']]]) ? $this->lookup[$this->lookup[$node][$this->properties['id_column']]] : 0;
            
            // if script gets this far, return false as something must've went wrong
            return false;
    }
    
    public function getAllWithThisPid($pid = 0) 
    {
        $query = "SELECT
            	c.id, 
            	c.pid, 
                c.name, 
                c.image,
                ((c.rgt - c.lft) > 1) as has_child
            FROM categories as c
            WHERE c.pid = '{$pid}';";
        
        try {
            return $this->database->query($query)->fetchAll();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function getParentsTree($pid, $parents) {
        if ($pid > 0) {
            $parent = $this->get_parent($pid);
            if (!empty($parent)) {
                $parents[] = $parent;
                if ($parent['pid'] > 0) {
                    $parents = $this->getParentsTree($parent['id'], $parents);
                }
            }
        }
        return $parents;
    }
    
    public function getCategoryTree($pid, $parents) {
        $parents[] = $this->get_details ($pid);
        return array_reverse($this->getParentsTree($pid, $parents));
    }
    
    public function getById($id)
    {
        $query = "SELECT
            c.id, c.pid, c.name,
            SUBSTR(c.description, 1, 100) as description,
            c.image
        FROM categories as c
        WHERE c.id = '{$id}';";
        
        try {
            return $this->database->query($query)->fetch();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
}

