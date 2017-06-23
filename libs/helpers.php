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
		return lcfirst(strtocamel($input));
	}
}
