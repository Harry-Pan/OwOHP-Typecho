<?php
use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Widget\Options;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 以插件的形式为你的博客提供OwO表情支持。自带将中文名称的表情包转码并生成索引的功能。
 *
 * @package OwO表情插件
 * @author HarryPan
 * @version 1.0.0
 * @link https://github.com/Harry-Pan/OwOHP-Typecho
 */
 class OwOHP_Plugin implements Typecho_Plugin_Interface {
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('OwOHP_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('OwOHP_Plugin', 'footer');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('OwOHP_Plugin','contentEx');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('OwOHP_Plugin', 'contentEx');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('OwOHP_Plugin','commentcontentEx');
        //如果你的主题已经在文章编辑页面加入了OwO按钮，可以根据情况注释掉以下三行
        Typecho_Plugin::factory('admin/write-post.php')->bottom = array('OwOHP_Plugin', 'addButton');
        Typecho_Plugin::factory('admin/write-page.php')->bottom = array('OwOHP_Plugin', 'addButton');
        Typecho_Plugin::factory('admin/write-page.php')->footer = array('OwOHP_Plugin', 'footer');
    }

    /**
     * 正文的表情解析
     *
     * @access public
     * @return $text
     */
    static public function contentEx($data, $widget, $last){
        $text = empty($last)?$data:$last;
        if ($widget instanceof Widget_Archive) {
            $text = self::parseOwO($text);
        }
        return $text;
    }
    /**
     * 正文的表情解析
     *
     * @return void
     */
    public static function commentcontentEx($con,$obj,$text)
    {
        $text = empty($text)?$con:$text;
        $text = self::parseOwOCOmment($text);
         return $text;
}

    /**
     * 解析 OwO表情
     * 
     * @return string
     */
    static public function parseOwO($string){
        $string = preg_replace_callback('/\$\(\s*(.*?)\s*\)\$/is',
            array('OwOHP_Plugin', 'parseOwOCallback'), $string);
        return $string;
    }
    /**
     * 表情回调函数
     * 
     * @return string
     */
    private static function parseOwOCallback($match){
        $owopath=$match[1];
        $sign=strcspn($owopath,'_');
        $owoname=substr($owopath,$sign+1);
        $owopath=strstr($owopath,'_',true);
        str_replace('%', '', urlencode($owoname));

        return '<img class="owobiaoqing" src="/usr/plugins/OwOHP/owo/biaoqing/'.$owopath.'/'.str_replace('%', '', urlencode($owoname)). '.png">';
    }

    /**
     * 解析评论中的OwO表情
     * 
     * @return string
     */
    static public function parseOwOCOmment($string){
        $string = preg_replace_callback('/\$\(\s*(.*?)\s*\)\$/is',
            array('OwOHP_Plugin', 'parseOwOCallbackComment'), $string);
        return $string;
    }
    /**
     * 评论表情回调函数
     * 
     * @return string
     */
    private static function parseOwOCallbackComment($match){
        $owopath=$match[1];
        $sign=strcspn($owopath,'_');
        $owoname=substr($owopath,$sign+1);
        $owopath=strstr($owopath,'_',true);
        str_replace('%', '', urlencode($owoname));

        return '<owo-img srcd="'.$owopath.'/'.str_replace('%', '', urlencode($owoname)).'.png"></owo-img>';
    }

    /**
     * 引入OwO
     * 
     * @return void
     */
    public static function header(){
        $imagesize = Helper::options()->plugin('OwOHP')->imagesize;
        echo '<script src="';
        Helper::options()->pluginUrl('/OwOHP/owo/owoHP.js');
        echo '"></script>';

        echo '<link rel="stylesheet" href="';
        Helper::options()->pluginUrl('/OwOHP/owo/owo.min.css');
        echo '" />';
        echo '<style>#custom-field textarea,#custom-field input{width:100%}
        .OwO span{background:none!important;width:unset!important;height:unset!important}
        .OwO .OwO-body .OwO-items{
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden;
        }
        .OwO .OwO-body .OwO-items-image .OwO-item{
            max-width:-moz-calc(20% - 10px);
            max-width:-webkit-calc(20% - 10px);
            max-width:calc(20% - 10px)
        }
        @media screen and (max-width:767px){    
            .comment-info-input{flex-direction:column;}
            .comment-info-input input{max-width:100%;margin-top:5px}
            #comments .comment-author .avatar{
                width: 2.5rem;
                height: 2.5rem;
            }
        }
        @media screen and (max-width:760px){
            .OwO .OwO-body .OwO-items-image .OwO-item{
                max-width:-moz-calc(25% - 10px);
                max-width:-webkit-calc(25% - 10px);
                max-width:calc(25% - 10px)
            }
        }
        .wmd-button-row{height:unset}</style>';
        echo '<style>
        img.owobiaoqing {
    display: inline-block;
    height: '.$imagesize.';
    vertical-align: bottom;
    margin: 0;
    box-shadow: none;
}</style>

';
    }


    /**
     * 新建OwO与自定义元素
     * 
     * @return void
     */
    public static function footer(){
?>
<script>
        // if($(".OwO").length > 0){
            new OwO({
                logo: 'OωO',
                container: document.getElementsByClassName('OwO')[0],
                target: document.getElementsByClassName('input-area')[0],
                api: '<?php Helper::options()->pluginUrl('/OwOHP/owo/OwOHP.json'); ?>',
                position: 'down',
                width: '400px',
                maxHeight: '250px'
            });
        // }
        </script>
<script>
class owoimg extends HTMLElement {
    constructor() {
    super();
    const srcd="/usr/plugins/OwOHP/owo/biaoqing/"+this.getAttribute("srcd");
    const templateDom = document.createElement("template");
        templateDom.innerHTML = `
            <img style="display: inline-block;height:<?php echo Helper::options()->plugin('OwOHP')->imagesize; ?>;vertical-align: bottom;margin: 0;
    box-shadow: none;" src="`+srcd+`">
        `;

        const divTemplate = templateDom.content;
        
        // open 表示可以通过页面内的 JavaScript 方法来获取 Shadow DOM
        let shadowDom = this.attachShadow({ mode: "open" }); 
        
        shadowDom.append(divTemplate);
    }
}
customElements.define("owo-img",owoimg);
</script>
<?php
    }

    /**
     * 编辑界面添加Button
     * 
     * @return void
     */
    public static function addButton(){
        echo '<script src="';
        Helper::options()->pluginUrl('/OwOHP/owo/owoHP.js');
        echo '"></script>';

        echo '<script src="';
        Helper::options()->pluginUrl('/OwOHP/owo/editor.js');
        echo '"></script>';

        echo '<link rel="stylesheet" href="';
        Helper::options()->pluginUrl('/OwOHP/owo/owo.min.css');
        echo '" />';
       
        echo '<style>#custom-field textarea,#custom-field input{width:100%}
        .OwO span{background:none!important;width:unset!important;height:unset!important}
        .OwO .OwO-body .OwO-items{
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden;
        }
        .OwO .OwO-body .OwO-items-image .OwO-item{
            max-width:-moz-calc(20% - 10px);
            max-width:-webkit-calc(20% - 10px);
            max-width:calc(20% - 10px)
        }
        @media screen and (max-width:767px){    
            .comment-info-input{flex-direction:column;}
            .comment-info-input input{max-width:100%;margin-top:5px}
            #comments .comment-author .avatar{
                width: 2.5rem;
                height: 2.5rem;
            }
        }
        @media screen and (max-width:760px){
            .OwO .OwO-body .OwO-items-image .OwO-item{
                max-width:-moz-calc(25% - 10px);
                max-width:-webkit-calc(25% - 10px);
                max-width:calc(25% - 10px)
            }
        }
        .wmd-button-row{height:unset}</style>';
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate(){}
    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */

    public static function config(Form $form){
?>
<p>
    <h3>使用方式示例</h3>
    &lt;div class=&quot;OwO&quot;&gt;&lt;/div&gt;<br>
    &lt;span class=&quot;OwO&quot; aria-label=&quot;表情按钮&quot; role="button"&gt;&lt;/span&gt;
</p>
<p>只要class为OwO，该元素便会与表情按钮绑定。</p>
<p>在新增/删除表情包后请<a href="<?php Helper::options()->index('/OwOHP?action=rebuild'); ?>" target="_blank">重建索引</a>。</p>
<?php
        $form->addInput(new Typecho_Widget_Helper_Form_Element_Text('imagesize', NULL, '3.5em', '设置表情包尺寸(单位采用css单位，默认3.5em)'));

    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form){}
}
