---
title: Static blog với pekyll
layout: post
---

## Tại sao lại viết pekyll xD

Tình hình là dạo này mình cũng có nhiều thời gian rảnh, tính viết linh tinh gì đấy. Tất nhiên là chỉ cần những cái đơn giản kiểu markdown là đủ, ko cần phải wordpress setup linh tinh.

Mình cũng có xem qua [Jekyll](https://jekyllrb.com/), thằng này generate nội dung thành các file static html và dùng được với github pages luôn, quá tiện 😊. Đọc qua doc thì thấy sử dụng liquid template và build bằng ruby. Mình thì ko biết ruby, và thấy sử dụng `liquid` template engine này cũng ngại đọc, mà chắc ko bằng `blade` template engine của laravel đâu xD, nên cũng có tìm qua 1 số thằng mà thấy nhiều chức năng mình ko cần. Nên tự build 1 thằng riêng xài cho dễ.

## Ý tưởng ban đầu

Sau khi tham thảo jekyll -> đây cũng là tại sao mình đặt tên là pekyll (jekyll in php) xD, thì mình nghĩ chỉ cần những chức năng này là đủ:

- parse file markdown
- build ra file htmls và deploy lên github page
- sử dụng blade của laravel

Cái mình thích nhất ở blade những phiên bản gần đây của laravel ở việc support view component, và mình muốn có thể sử dụng [`anonymous components`](https://laravel.com/docs/master/blade#anonymous-components) trong pekyll.

## Thực hiện

Thực ra ý tưởng đơn giản nên cũng ko cần phải làm cầu kì viết từ scratch làm gì, cài cắm package các kiểu cũng gần đủ hỗ trợ cho các chức năng rồi xD. Và blog này mình sử dụng chính [`pekyll on github`](https://github.com/bangnokia/pekyll) luôn 😜.
