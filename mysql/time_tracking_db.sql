-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: db
-- 生成日時: 2024 年 1 月 18 日 06:49
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
-- テーブルの構造 `account_tbl`
--

CREATE TABLE `account_tbl` (
  `user_id` int UNSIGNED NOT NULL,
  `passwd` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `auth` int NOT NULL,
  `type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `account_tbl`
--

INSERT INTO `account_tbl` (`user_id`, `passwd`, `user_name`, `auth`, `type`) VALUES
(11111, '', '管理者', 1, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `device_tbl`
--

CREATE TABLE `device_tbl` (
  `idx` int UNSIGNED NOT NULL,
  `device_id` int UNSIGNED NOT NULL,
  `ver` int UNSIGNED NOT NULL,
  `device_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `time_traking_tbl`
--

CREATE TABLE `time_traking_tbl` (
  `idx` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `device_tbl_idx` int UNSIGNED NOT NULL,
  `work_id` int UNSIGNED NOT NULL,
  `ref_device_tbl_idx` int UNSIGNED NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `work_tbl`
--

CREATE TABLE `work_tbl` (
  `work_id` int UNSIGNED NOT NULL,
  `work_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `result` int NOT NULL,
  `job_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `account_tbl`
--
ALTER TABLE `account_tbl`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `device_tbl`
--
ALTER TABLE `device_tbl`
  ADD PRIMARY KEY (`idx`);

--
-- テーブルのインデックス `time_traking_tbl`
--
ALTER TABLE `time_traking_tbl`
  ADD UNIQUE KEY `idx` (`idx`);

--
-- テーブルのインデックス `work_tbl`
--
ALTER TABLE `work_tbl`
  ADD UNIQUE KEY `work_id` (`work_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `device_tbl`
--
ALTER TABLE `device_tbl`
  MODIFY `idx` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `time_traking_tbl`
--
ALTER TABLE `time_traking_tbl`
  MODIFY `idx` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
