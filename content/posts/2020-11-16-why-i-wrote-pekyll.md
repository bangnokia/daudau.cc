---
layout: post
title: Why I wrote Pekyll
tags:
  - php
---
## Tại sao lại viết Pekyll xD {#why-pekyll}

Tình hình là dạo này mình có khá nhiều thời gian rảnh, nên tính viết linh tinh gì đấy. Tất nhiên, chỉ cần những thứ đơn giản kiểu Markdown là đủ; ko cần setup WordPress linh tinh.

Mình cũng có xem qua [Jekyll](https://jekyllrb.com/); thằng này generate nội dung thành các file static HTML và dùng được với GitHub Pages luôn, quá tiện 😊. Đọc qua docs thì thấy nó sử dụng Liquid template và build bằng Ruby. Mình thì ko biết Ruby, và thấy `liquid` template engine này cũng ngại đọc, mà chắc ko bằng `blade` template engine của Laravel đâu xD. Mình cũng có tìm qua 1 số thằng khác nhưng thấy nhiều chức năng mình ko cần, nên tự build 1 thằng riêng xài cho dễ.

## Ý tưởng ban đầu {#idea}

Sau khi tham khảo Jekyll -> đây cũng là tại sao mình đặt tên là Pekyll (Jekyll in PHP) xD, thì mình nghĩ chỉ cần những chức năng này là đủ:

- parse file markdown
- build ra các file HTML và deploy lên GitHub Pages
- sử dụng Blade của Laravel

Cái mình thích nhất ở Blade trong những phiên bản gần đây của Laravel là việc support view component, và mình muốn có thể sử dụng [`anonymous components`](https://laravel.com/docs/master/blade#anonymous-components) trong Pekyll.

## Thực hiện {#implementation}

Thực ra ý tưởng đơn giản nên cũng ko cần làm cầu kì hay viết từ scratch; cài cắm package các kiểu là gần đủ hỗ trợ cho các chức năng rồi xD. Và blog này mình đang sử dụng chính [`pekyll on GitHub`](https://github.com/bangnokia/pekyll) luôn 😜.
