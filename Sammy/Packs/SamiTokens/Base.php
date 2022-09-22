<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\SamiTokens
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\SamiTokens {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Sammy\Packs\SamiTokens\Base')){
  /**
   * @class Base
   * Base internal class for the
   * SamiTokens module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * wich should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  class Base {
    /**
     * All
     */
    private $abc = 'abcdefghijklmnopqrstuvwxyz';

    public function __construct(){

      /**
       * ...
       */
      $this->abc .= (strtoupper ($this->abc) . (
        join ('', range (0, 9))
      ));
    }

    /**
     * @method newToken
     * Generate a new token by the
     * specified pattern. default's:
     * a-zA-Z0-9
     */
    public function newToken($len = 11){

      $len = is_string($len) ? strtolower($len) : $len;

      $re = '/^(num(ber|eric|)|(abc|alpha)|(abc|alpha)num):/i';

      if(is_string($len) && preg_match( $re , $len, $t)){
        $l = preg_replace($re, '', $len);

        switch($t[0]){

          case 'num:':
          case 'number:':
          case 'numeric:':
            return $this->newNumericToken($l);
          break;

          case 'abc:':
          case 'alpha:':
            return $this->newAlphaToken($l);
          break;

          case 'abcnum:':
          case 'alphanum:':
          default:
            return $this->token($l);
          break;

        }

      }

      return $this->token($len);

    }

    /**
     * @method newToken
     * Generate a new token by the
     * a-zA-Z0-9 pattern
     */
    public function token($len = 11){
      /**
       * Token length
       */
      $len = is_numeric($len) ? ((int)($len)) : 11;

      /**
       * Current date
       */
      $d = getdate();

      /**
       * Alphanumeric characters
       */
      $abcn = $this->abc . (
        preg_replace('/([^0-9]+)/', '', join($d, ''))
      );

      /**
       * @var tk
       * Final generated token
       */
      $tk = '';

      /**
       * @var abc_array
       * abc array
       */
      $abc_array = preg_split( '/,+/' ,
        preg_replace('/,$/', '',
          preg_replace('/([a-zA-Z0-9]{4,5})/', '\\0,', $abcn)
        )
      );

      shuffle($abc_array);

      $abcn_datas = join($abc_array, '');

      for( $i=0; $i<$len; $i++ ){
        $tk .= $abcn_datas[ rand(0, (strlen($abcn_datas) - 1)) ];
      }

      return $tk;
    }

    /**
     * @method newToken
     * Generate a new token by the
     * a-zA-Z pattern
     */
    public function newAlphaToken($len = null){

      /**
       * Token length
       */
      $len = is_numeric($len) && ((int)($len)) >= 1 ? ((int)($len)) : 11;

      /**
       * Current date
       */
      $d = getdate();

      /**
       * Alphanumeric characters
       */
      $abcn = preg_replace('/([^a-zA-Z]+)/', '', $this->abc);

      /**
       * @var tk
       * Final generated token
       */
      $tk = '';

      /**
       * @var abc_array
       * abc array
       */
      $abc_array = preg_split( '/,+/' ,
        preg_replace('/,$/', '',
          preg_replace('/([a-zA-Z0-9]{4,5})/', '\\0,', $abcn)
        )
      );

      shuffle($abc_array);

      $abcn_datas = join($abc_array, '');

      for( $i=0; $i<$len; $i++ ){
        $tk .= $abcn_datas[ rand(0, (strlen($abcn_datas) - 1)) ];
      }

      return $tk;

    }

    /**
     * @method newToken
     * Generate a new token by the
     * 0-1 pattern
     */
    public function newNumericToken($len = null){

      /**
       * Token length
       */
      $len = is_numeric($len) && ((int)($len)) >= 1 ? ((int)($len)) : 11;

      /**
       * Current date
       */
      $d = getdate();

      /**
       * Alphanumeric characters
       */
      $abcn = preg_replace('/([^0-9\.]+)/', '', $this->abc);

      /**
       * @var tk
       * Final generated token
       */
      $tk = '';

      /**
       * @var abc_array
       * abc array
       */
      $abc_array = preg_split( '/,+/' ,
        preg_replace('/,$/', '',
          preg_replace('/([a-zA-Z0-9]{4,5})/', '\\0,', $abcn)
        )
      );

      shuffle($abc_array);

      $abcn_datas = join($abc_array, '');

      for ( $i=0; $i<$len; $i++ ) {
        $tk .= $abcn_datas[ rand(0, (strlen($abcn_datas) - 1)) ];
      }

      return $tk;
    }
  }}
}
