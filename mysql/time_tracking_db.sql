-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: db
-- 生成日時: 2023 年 12 月 10 日 11:30
-- サーバのバージョン： 8.2.0
-- PHP のバージョン: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `time_tracking_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `device_tbl`
--

CREATE TABLE `device_tbl` (
  `idx` int NOT NULL,
  `code` tinytext COLLATE utf8mb4_bin NOT NULL,
  `sharp` int NOT NULL,
  `name` tinytext COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_tbl`
--

CREATE TABLE `user_tbl` (
  `idx` int UNSIGNED NOT NULL,
  `employee_number` tinytext COLLATE utf8mb4_bin NOT NULL,
  `name` tinytext COLLATE utf8mb4_bin NOT NULL,
  `auth` int NOT NULL,
  `job_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `work_tbl`
--

CREATE TABLE `work_tbl` (
  `idx` int NOT NULL,
  `code` int UNSIGNED NOT NULL,
  `name` tinytext COLLATE utf8mb4_bin NOT NULL,
  `direct` int NOT NULL,
  `job_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `device_tbl`
--
ALTER TABLE `device_tbl`
  ADD PRIMARY KEY (`idx`);

--
-- テーブルのインデックス `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`idx`);

--
-- テーブルのインデックス `work_tbl`
--
ALTER TABLE `work_tbl`
  ADD PRIMARY KEY (`idx`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `device_tbl`
--
ALTER TABLE `device_tbl`
  MODIFY `idx` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `idx` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `work_tbl`
--
ALTER TABLE `work_tbl`
  MODIFY `idx` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
