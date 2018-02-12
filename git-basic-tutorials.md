# Đây là tut nhỏ và nhanh cho anh em trong nhóm làm quen với Git
# Git là gì?
Git là tên gọi của một Hệ thống quản lý phiên bản phân tán (**Distributed Version Control System – DVCS**) là một trong những hệ thống quản lý phiên bản phân tán phổ biến nhất hiện nay. *DVCS* nghĩa là hệ thống giúp mỗi máy tính có thể lưu trữ nhiều phiên bản khác nhau của một mã nguồn được nhân bản (clone) từ một kho chứa mã nguồn (repository), mỗi thay đổi vào mã nguồn trên máy tính sẽ có thể ủy thác (commit) rồi đưa lên máy chủ nơi đặt kho chứa chính. Và một máy tính khác (nếu họ có quyền truy cập) cũng có thể clone lại mã nguồn từ kho chứa hoặc clone lại một tập hợp các thay đổi mới nhất trên máy tính kia.
# Tại sao phải làm việc với Git và Github
Trước khi đi vào vấn đề này mình cần nhấn mạnh với các bạn rằng **Git và Github không phải là một** nên đừng đánh đồng chúng. Git là mô hình hệ thống, còn Github là một server phục vụ hệ thống đó, giúp cho chúng ta lưu trữ mã nguồn và tương tác giữa các nhà phát triển trên đó.

Lợi ích mà git và github mang lại rất lớn như: 
- Cung cấp một không gian lưu trữ mã nguồn.
- Git dễ sử dụng, an toàn và nhanh chóng. Git rất ít câu lệnh và dễ nhớ.
- Có thể giúp quy trình làm việc code theo nhóm đơn giản hơn rất nhiều bằng việc kết hợp các phân nhánh (branch).
- Bạn có thể làm việc ở bất cứ đâu vì chỉ cần clone mã nguồn từ kho chứa hoặc clone một phiên bản thay đổi nào đó từ kho chứa, hoặc một nhánh nào đó từ kho chứa.
- Dễ dàng trong việc deployment sản phẩm.
- Và giúp bạn có một profile đẹp khi đi xin việc sau này.
# Các bước cài đặt và sử dụng
## Cài đặt git trên Windows
Các bạn tải và cài đặt Git cho Windows theo đường link sau: https://git-scm.com/download/win
Sau khi cài đặt thành công thì bạn cần cấu hình cơ bản cho git. Để cấu hình bạn có thể sử dụng **Git Bash** hoặc **Windows PowerShell** (mình khuyên dùng PowerShell nhé).

Đầu tiên là cấu hình username mặc định:
```
git config --global user.name "Your name here"
```
Tiếp theo là cấu hình địa chỉ Email. Git lưu địa chỉ email vào những commit mà chúng ta tạo. Chúng ta sử dụng địa chỉ email để liên kết các commit của bản thân với tài khoản github.
```
git config --global user.email "your_email@example.com"
```
Email của chúng ta phải giống với email đăng kí tài khoản github.
Đến đây thì cơ bản chúng ta đã hoàn tất xong việc cài đặt git trên máy của chúng ta.
## Tạo tài khoản trên github.com
Việc tạo tài khoản trên github là bước không thể thiếu. Bạn truy cập vào https://github.com và thực hiện đăng ký một tài khoản.
Sau khi tạo tài khoản xong thì đưa thông tin tài khoản (username) cho mình để mình add vào team để có quyền commit lên nhánh master nhé.
## Clone project về máy local
Trước khi clone project về máy thì chúng ta cần xác định thư mục mà các bạn sẽ chứa source code. Các bạn dùng lệnh **cd** để cd đến thư mục mà các bạn muốn làm việc.

Sau đó dùng lệnh sau để clone project về:
```
git clone https://github.com/ptudweb-lab/project
```
## Thử commit một file bất kì
Bây giờ bạn có thể commit một file lên, thử tạo một file bất kì trong thư mục chứa project. Ví dụ test.php với nội dung gì tùy bạn.

Sau đó sử dụng lệnh sau để đưa file test.php vào nơi chờ commit
```
git add test.php
```
Tiếp tục ta sẽ commit với lệnh sau:
```
git commit -am "What do you do?"
```
Chú ý dòng **"What do you do?"** là dòng comment cho commit cho chúng ta, các bạn hết sức chú ý đến comment này, comment này giúp mọi người hiểu bạn đã làm gì với các dòng code. Các bạn cần làm rõ mình đã làm gì?!!
## Push các commit lên remote repository
Ta cần hiểu github là một remote repository, còn trên máy chúng ta là local repository. Chúng ta chỉnh sửa code trên máy và thực hiện commit thì commit đó chỉ lưu trên local repository chứ chưa đưa lên remote repository nên mọi người chung team sẽ không thấy những thay đổi của bạn.

Để cập nhật lên remote repository thì bạn cần dùng lệnh push:
```
git push origin master
```
Giải thích:
- **origin** là bí danh cho remote repository. Mặc định khi bạn không thiết lập gì khi clone thì nó được đặt origin
- **master** là tên nhánh (Branch).
Sau đó git sẽ yêu cầu bạn đăng nhập vào tài khoản github thực hiện push.

## Pull các thay đổi từ remote repository về máy local
Một điều hết sức cần các bạn chú ý là trước khi commit hay push lên remote repository thì các bạn cần cập nhật các thay đổi từ remote repository. Để xem có người nào đó chung team có đang viết cùng file mình đang viết hay không. Để tránh sự xung đột.

Để cập nhật các thay đổi trên remote repository thì các bạn cần kéo (pull) các dữ liệu thay đổi từ remote repository về bằng lệnh sau:

```
git pull
```

Cơ bản chỉ có bao nhiêu lệnh. Đơn giản phải không nào. Chúc các học tập thật tốt!

--Lê Hoàng Tuấn--
