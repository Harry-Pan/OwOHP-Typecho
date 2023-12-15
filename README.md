# OwOHP-Typecho：OwO表情插件

以插件的形式为你的博客提供OwO表情支持。

自带将中文名称的表情包转码并生成索引的功能。

[demo](https://www.harrypan.cn)

## 注意事项

- 本插件在Typecho1.2.1版本开发设计，暂时不保证在1.2.0以下的版本的兼容性问题。
- 本插件尚在测试阶段，插件配置较繁琐，且需要一定基础，请谨慎安装。
- 如果你使用的主题已经嵌入了OwO，请小心谨慎地考虑兼容性问题。我会在末尾给出一份解决兼容性问题的修改建议。
- 如果你在确认以上注意事项后仍决定尝试本插件，请在通读本md后再动手。

## 配置步骤

### 基础配置

1. 将插件解压后重命名为`OwOHP`，并复制到`usr/plugins`目录。
2. 将存有表情的文件夹放置在本插件目录下的`OwOHP/owo/biaoqing`位置。
3. 进入后台，启用本插件。进入本插件的配置页面，点击**重建索引**。

此时进入后台的文章和页面编辑界面，可以看到编辑器功能栏出现OwO按钮，点击按钮可正常显示导航栏为表情的表情菜单，点击表情可在编辑器内插入对应文本，则表示基础配置成功。

![image-20231215151740105](https://cos.harrypan.cn/WaiMaoTuChuang/image-20231215151740105.png)

### 为评论区配置表情按钮

**在对主题进行任何修改前，请先备份主题文件，以免出现意外。**

1. 检查你的主题评论区的源码，将插件内178行括号内的`input-area`改为主题评论区输入框的class属性名称。

2. 进入后台-评论设置，**在允许使用的HTML标签和属性**中加入`<owo-img class="owobiaoqing" srcd="">`

3. 在你想要放置表情按钮的位置插入表情按钮的代码。按钮的class属性应为`OwO`。

   以下是表情按钮代码的示例：

   ```<div class="OwO"></div>```

   ```<span class="OwO" aria-label="表情按钮" role="button"></span>```



完成以上步骤后，在插入按钮的位置可以显示按钮，选择表情后会在评论区文本框内插入文本，即为配置成功。

### 表情文件夹的格式

在选择表情后，插入输入框的文本格式为：`$(表情文件夹名_表情文件名)$`

表情文件夹请使用不包含空格和特殊符号的纯英文和数字名称。

各个表情的后缀名需为png，名称没有限制。

表情文件夹内应当包含icon.png，该文件为这组表情包的图标，不会被收录在选项内，会显示在表情选择框下方的导航栏。

以下是一个标准的表情文件夹的示范。

![image-20231215160734322](https://cos.harrypan.cn/WaiMaoTuChuang/image-20231215160734322.png)

在这里额外提供[几个表情包](http://disk.harrypan.cn:8080/cos-1-nanjing/OwOHP)，供各位参考和使用。

## 主题兼容性问题

一些主题（如VOID）内嵌了OwO，这类主题在使用本插件时极有可能出现各类兼容性问题，目前不推荐安装本插件。如果你仍希望安装本插件，以下是一些解决兼容性问题的指导：

**在对主题进行任何修改前，请先备份主题文件，以免出现意外。**

在主题的所有css文件中查找`OwO-bar`，检查其属性，如果属性中包含`height`则将其值改为`40px flex`

在主题的所有文件中查找`new OwO`，将其紧随函数参数中的“API”参数的内容改为`'/usr/plugins/OwOHP/owo/OwOHP.json'`。

在主题的所有文件中查找`<ul class="OwO-packages">`,在其下一行找到类似`<li><span>" + this.packages[变量名] + "</span></li>`的内容，将其改为`<li><span>" + this.odata[this.packages[变量名]].icon + "</span></li>`

**最后再次提醒，目前不推荐内嵌了OwO的主题安装本插件。**

# 感谢

[OwO](https://github.com/DIYgod/OwO) [Typecho-Theme-VOID](https://github.com/AlanDecode/Typecho-Theme-VOID) [Mikusa](https://github.com/mikusaa)

# Lisence

MIT