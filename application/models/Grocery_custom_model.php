<?php

class Grocery_custom_model extends grocery_CRUD_Model {

	public function join_relation($field_name , $related_table , $related_field_title)
    {
		$related_primary_key = $this->get_primary_key_new($related_table, $field_name);

		if($related_primary_key !== false)
		{
			$unique_name = $this->_unique_join_name($field_name);
			$this->db->join( $related_table.' as '.$unique_name , "$unique_name.$related_primary_key = {$this->table_name}.$field_name",'left');

			$this->relation[$field_name] = array($field_name , $related_table , $related_field_title);

			return true;
		}

    	return false;
    }
    
    public function get_primary_key_new($related_table, $field_name = '')
    {
		if ($field_name == '')
		{
			$related_primary_key = parent::get_primary_key($related_table);
		}
		else
		{
			$part = explode('_', $field_name);
			$last_index = count($part) - 1;
			$related_primary_key = $part[$last_index];
		}
		
		return $related_primary_key;
	}
    
    public function get_relation_array($field_name , $related_table , $related_field_title, $where_clause, $order_by, $limit = null, $search_like = null)
    {
    	$relation_array = array();
    	$field_name_hash = $this->_unique_field_name($field_name);

    	$related_primary_key = $this->get_primary_key_new($related_table, $field_name);

    	$select = "$related_table.$related_primary_key, ";

    	if(strstr($related_field_title,'{'))
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    	}
    	else
    	{
	    	$select .= "$related_table.$related_field_title as $field_name_hash";
    	}

    	$this->db->select($select,false);
    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($limit !== null)
    		$this->db->limit($limit);

    	if($search_like !== null)
    		$this->db->having("$field_name_hash LIKE '%".$this->db->escape_like_str($search_like)."%'");

    	$order_by !== null
    		? $this->db->order_by($order_by)
    		: $this->db->order_by($field_name_hash);

    	$results = $this->db->get($related_table)->result();

    	foreach($results as $row)
    	{
    		$relation_array[$row->$related_primary_key] = $row->$field_name_hash;
    	}

    	return $relation_array;
    }
}
