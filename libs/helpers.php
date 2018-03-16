<?php

if( !function_exists('array_transposition') )
{
	/**
	 * Transposition an 2-dimensional array.
	 *
	 * @param  array $input
	 *
	 * @return array
	 */
	function array_transposition( array$input )
	{
		$keys=   array_keys($input);
		$values= array_values($input);

		return array_combine(
			array_keys( $values[0] )
			,
			array_map(
				function( ...$args )use( $keys ){
					return array_combine( $keys, $args );
				}
				,
				...$values
			)
		);
	}
}


if( !function_exists( 'preg_get' ) && function_exists( 'preg_match' ) )
{
	/**
	 * Perform a regular expression match and get the match.
	 * @param  string  $pattern
	 * @param  string  $subject
	 * @param  mixed  $index
	 * @return string|null
	 */
	function preg_get( string$pattern, string$subject, $index=0 )
	{
		preg_match( $pattern, $subject, $matches );

		return isset($index)? $matches[$index]??null : $matches;
	}
}


if( !function_exists('array_take') )
{
	/**
	 * Take an item from an array.
	 *
	 * @param  array  $array
	 * @param  mixed  $key
	 *
	 * @return mixed
	 */
	function array_take( array&$array , $key )
	{
		if( array_key_exists( $key, $array ) )
		{
			$value= $array[$key];

			unset($array[$key]);

			return $value;
		}

		return null;
	}
}


if( !function_exists('strrstr') )
{
	/**
	 * strstr from right to left.
	 *
	 * @param  string $haystack
	 * @param  mixed  $needle
	 * @param  boll   $before_needle
	 *
	 * @return string
	 */
	function strrstr( string$haystack , $needle, bool$before_needle=false )
	{
		return strrev(strstr( strrev($haystack), $needle, $before_needle ));
	}
}


if( !function_exists('decb64') )
{
	/**
	 * strstr from right to left.
	 *
	 * @param  numaric $num
	 *
	 * @return string
	 */
	function decb64($num){
		$key='';

		do{
			$n=$num%0x40;

			(
				$n<=9 and ($key.=$n or 1)
			)or(
				$n<=0x23 and $key.=chr($n+0x57)
			)or(
				$n<=0x3D and $key.=chr($n+0x1D)
			)or(
				$n==0x3F and $key.='-'
			)or(
				$key.='_'
			);

			$num=$num>>6;

		}while($num>0);

		return $key;
	}
}


if( !function_exists('b64dec') )
{
	/**
	 * strstr from right to left.
	 *
	 * @param  string $key
	 *
	 * @return int
	 */
	function b64dec($key){
		$num=0;
		for($i=strlen($key)-1;$i>=0;--$i)
		{
			$n=ord($key{$i});

			(
				$n==0x2D and $n=0x3F
			)or(
				$n==0x5F and $n=0x3E
			)or(
				$n>=0x30 && $n<=0x39 and ($n-=0x30 or 1)
			)or(
				$n>=0x41 && $n<=0x5A and $n-=0x1D
			)or(
				$n>=0x61 && $n<=0x7A and $n-=0x57
			);

			$num+=$n<<($i*6);
		}

		return $num;
	}
}


if( !function_exists('decany') )
{
	/**
	 * strstr from right to left.
	 *
	 * @param  numaric $number
	 * @param  string  $radix
	 *
	 * @return string
	 */
	function decany( $number , string$redix )
	{
		$base= strlen( $redix );
		$key= '';

		if( $base<=1 )
		{
			throw new \Exception( 'Parameter $redix for decany must has at less 2 characters.' );
		}

		do{
			$n= $number%$base;

			$key.= $redix{$n};

			$number= floor( $number/$base );

		}while( $number>=1 );

		return strrev( $key );
	}
}


if( !function_exists('anydec') )
{
	/**
	 * strstr from right to left.
	 *
	 * @param  string $key
	 * @param  string  $radix
	 *
	 * @return int
	 */
	function anydec( string$key , string$redix )
	{
		$base= strlen( $redix );
		$number= 0;

		if( $base<=1 )
		{
			throw new \Exception( 'Parameter $redix for anydec must has at less 2 characters.' );
		}

		for(  $i= 0, $l= strlen( $key );  $i<$l; ++$i  )
		{
			$pos= strpos( $redix, $key{$i} );

			if( $pos===false )
			{
				throw new \Exception( "'$key' is not a '$redix' base number" );
			}

			$number*=$base;
			$number+=$pos;
		}

		return $number;
	}
}


if( !function_exists( 'strcmplen' ) )
{
	/**
	 * compare two strings and return compared length
	 *
	 * @param  string $str1
	 * @param  string $str2
	 *
	 * @return int
	 */
	function strcmplen( string$str1, string$str2 ):int
	{
		$length= min( strlen( $str1 ), strlen( $str2 ) );

		for(  $i= 0;  $i<$length;  ++$i  )
		{
			if( strcmp( $str1{$i}, $str2{$i} ) )
			{
				return $i;
			}
		}

		return $length;
	}
}


if( !function_exists( 'strcasecmplen' ) )
{
	/**
	 * compare two strings and return compared length
	 *
	 * @param  string $str1
	 * @param  string $str2
	 *
	 * @return int
	 */
	function strcasecmplen( string$str1, string$str2 ):int
	{
		$length= min( strlen( $str1 ), strlen( $str2 ) );

		for(  $i= 0;  $i<$length;  ++$i  )
		{
			if( strcasecmp( $str1{$i}, $str2{$i} ) )
			{
				return $i;
			}
		}

		return $length;
	}
}


if( !function_exists('strtosnake') )
{
	/**
	 * Change 'AbcDEFGhiJkh' or 'abcDefGhiJkh' to 'abc_def_ghi_jkh'.
	 *
	 * @param  string $input
	 *
	 * @return string
	 */
	function strtosnake( string$input ):string
	{
		return strtolower(preg_replace('/(?<=[^A-Z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][^A-Z])/','_',$input));
	}
}


if( !function_exists('strtostudly') )
{
	/**
	 * Change 'abc_def-ghi jkh' to 'AbcDefGhiJkh'.
	 *
	 * @param  string $input
	 *
	 * @return string
	 */
	function strtostudly( string$input ):string
	{
		return str_replace(' ','',ucwords(str_replace(['-', '_'], ' ', $input)));
	}
}


if( !function_exists('strtocamel') )
{
	/**
	 * Change 'abc_def-ghi jkh' to 'abcDefGhiJkh'.
	 *
	 * @param  string $input
	 *
	 * @return string
	 */
	function strtocamel( string$input ):string
	{
		return lcfirst(strtostudly($input));
	}
}


if( !function_exists('array_reduce_better') )
{
	/**
	 * A better .
	 *
	 * @param  array $array
	 *
	 * @return mixed
	 */
	function array_reduce_better( array$array, callable$callback, $initial=null )
	{
		$origin= $array;

		func_num_args()<3 and $initial= array_shift( $array );

		foreach( $array as $key=>$value )
		{
			$initial= $callback( $initial, $value, $key, $origin );
		}

		return $initial;
	}
}


if( !function_exists('array_map_better') )
{
	/**
	 * A better .
	 *
	 * @param  array $array
	 *
	 * @return mixed
	 */
	function array_map_better( array$array, callable$callback )
	{
		return array_combine(
			$keys= array_keys( $array )
		,
			array_map( $callback, $keys, $array )
		);
	}
}


if( !function_exists('mksdir') ){
	/**
	 * Make sure dir, make sure the dir exists.
	 *
	 * @param  string  $dirname
	 *
	 * @return void
	 */
	function mksdir( string$dirname, $mod=0755 )
	{
		if( file_exists( $dirname ) )
		{
			if(!( is_dir( $dirname ) ))
			{
				throw Error( "There is a file named '$dirname' , cannot make dir." );
			}
		}else{
			mkdir( $dirname, $mod, true );
		}
	}
}


if( !function_exists('mkobj') ){
	/**
	 * Make a null object if null.
	 *
	 * @param  mixed  $origin
	 *
	 * @return void
	 */
	function mkobj( $origin )
	{
		return $origin??new class{
			public function __toString():string {  return '';  }
			public function __toBool():string {  return false;  }
			public function __toInt():string {  return 0;  }
			public function __toFloat():string {  return 0.0;  }
			public function __invork():string {  return null;  }
			public function __call( string$method, array$parameters ) {  return null;  }
			public function __get( string$property ) {  return null;  }
			public static function __callStatic( string$method, array$parameters ) {  return null;  }
			public static function __getStatic( string$property ) {  return null;  }
		};
	}
}


if( !function_exists('call_user_func_assoc') ){
	/**
	 * Call function with an assoc array, pass parameters with the same name.
	 *
	 * @param  callable  $function
	 *
	 * @return void
	 */
	function call_user_func_assoc( callable$function, array$param_arr=[] )
	{
		$params= (
			is_array( $function )
			? new ReflectionMethod( ...$function )
			: new ReflectionFunction( $function )
		)->getParameters();

		return $function(
			...array_map( function( $param )use( $param_arr ){
				return $param_arr[$param->name]??$param->getDefaultValue()??null;
			}, $params )
		);
	}
}
