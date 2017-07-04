getDynaDescription Extra for MODX Revolution
============================================

**Original Author:** Unknown

**Revolution Author:** Bob Ray [Bob's Guides](https://bobsguides.com)



Documentation is available at [Bob's Guides] (https://bobsguides.com/getdynadescription-snippet-tutorial.html)

The getDynaDescription snippet creates a description Meta tag in the &lt;head&gt; section of your template(s). Depending on the properties set, it will create the description from a TV, from the description field of the resource, or from the beginning of the content field of the resource. If the TV and the description field are empty, it will always use the beginning of the content field. That means that just by installing it, you can have a meaningful description Meta tag for every page of your site (assuming that you choose the option to insert the snippet tag in your templates or have it there already).

The original snippet returned only the text for the content section of the tag and required you to surround the tag with a Meta description tag of your own. This version has that option, but will also auto-create the entire Meta tag for you so all you need in the template is the snippet tag (with &amp;fullTag=`` `1` `` as a property).

 During the install, you can choose to have the TV created and select templates to attach it to. You can also choose from various versions of the snippet tag and have them inserted automatically into the &lt;head&gt;> section of selected templates on your site.

Using the resource's description field is the recommended method, because it will give you the fastest page load times and requires no database queries or extra processing, since that field is already available on each page request.