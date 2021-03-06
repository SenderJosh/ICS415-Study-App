USE [master]
GO
/****** Object:  Database [StudyApp]    Script Date: 12/15/2019 8:28:14 PM ******/
CREATE DATABASE [StudyApp]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'StudyApp', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.MSSQLSERVER\MSSQL\DATA\StudyApp.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'StudyApp_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.MSSQLSERVER\MSSQL\DATA\StudyApp_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [StudyApp] SET COMPATIBILITY_LEVEL = 130
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [StudyApp].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [StudyApp] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [StudyApp] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [StudyApp] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [StudyApp] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [StudyApp] SET ARITHABORT OFF 
GO
ALTER DATABASE [StudyApp] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [StudyApp] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [StudyApp] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [StudyApp] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [StudyApp] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [StudyApp] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [StudyApp] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [StudyApp] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [StudyApp] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [StudyApp] SET  DISABLE_BROKER 
GO
ALTER DATABASE [StudyApp] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [StudyApp] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [StudyApp] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [StudyApp] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [StudyApp] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [StudyApp] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [StudyApp] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [StudyApp] SET RECOVERY FULL 
GO
ALTER DATABASE [StudyApp] SET  MULTI_USER 
GO
ALTER DATABASE [StudyApp] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [StudyApp] SET DB_CHAINING OFF 
GO
ALTER DATABASE [StudyApp] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [StudyApp] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [StudyApp] SET DELAYED_DURABILITY = DISABLED 
GO
EXEC sys.sp_db_vardecimal_storage_format N'StudyApp', N'ON'
GO
ALTER DATABASE [StudyApp] SET QUERY_STORE = OFF
GO
USE [StudyApp]
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET LEGACY_CARDINALITY_ESTIMATION = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET MAXDOP = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET PARAMETER_SNIFFING = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET QUERY_OPTIMIZER_HOTFIXES = PRIMARY;
GO
USE [StudyApp]
GO
/****** Object:  Table [dbo].[failed_jobs]    Script Date: 12/15/2019 8:28:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[failed_jobs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[connection] [nvarchar](max) NOT NULL,
	[queue] [nvarchar](max) NOT NULL,
	[payload] [nvarchar](max) NOT NULL,
	[exception] [nvarchar](max) NOT NULL,
	[failed_at] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[GroupPostTbl]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[GroupPostTbl](
	[GroupPostID] [bigint] IDENTITY(1,1) NOT NULL,
	[GroupOwnerID] [bigint] NOT NULL,
	[GroupName] [nvarchar](75) NOT NULL,
	[ClassName] [nvarchar](75) NOT NULL,
	[Topics] [nvarchar](max) NOT NULL,
	[GroupDescription] [nvarchar](max) NOT NULL,
	[Monday] [bit] NOT NULL,
	[Tuesday] [bit] NOT NULL,
	[Wednesday] [bit] NOT NULL,
	[Thursday] [bit] NOT NULL,
	[Friday] [bit] NOT NULL,
	[Saturday] [bit] NOT NULL,
	[Sunday] [bit] NOT NULL,
	[Deleted] [bit] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [PK__GroupPos__A708807B6EA352EE] PRIMARY KEY CLUSTERED 
(
	[GroupPostID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[GroupTbl]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[GroupTbl](
	[GroupID] [bigint] IDENTITY(1,1) NOT NULL,
	[GroupUserID] [bigint] NOT NULL,
	[GroupPostID] [bigint] NOT NULL,
	[Accepted] [bit] NOT NULL,
	[Deleted] [bit] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [PK__GroupTbl__149AF30A32C857CA] PRIMARY KEY CLUSTERED 
(
	[GroupID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[migrations]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[migrations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[migration] [nvarchar](255) NOT NULL,
	[batch] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[password_resets]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[password_resets](
	[email] [nvarchar](255) NOT NULL,
	[token] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[google_id] [nvarchar](255) NOT NULL,
	[remember_token] [nvarchar](100) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [password_resets_email_index]    Script Date: 12/15/2019 8:28:15 PM ******/
CREATE NONCLUSTERED INDEX [password_resets_email_index] ON [dbo].[password_resets]
(
	[email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [users_email_unique]    Script Date: 12/15/2019 8:28:15 PM ******/
CREATE UNIQUE NONCLUSTERED INDEX [users_email_unique] ON [dbo].[users]
(
	[email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[failed_jobs] ADD  DEFAULT (getdate()) FOR [failed_at]
GO
ALTER TABLE [dbo].[GroupPostTbl] ADD  CONSTRAINT [DF_GroupPostTbl_Deleted]  DEFAULT ((0)) FOR [Deleted]
GO
ALTER TABLE [dbo].[GroupTbl] ADD  CONSTRAINT [DF_GroupTbl_Accepted]  DEFAULT ((0)) FOR [Accepted]
GO
ALTER TABLE [dbo].[GroupTbl] ADD  CONSTRAINT [DF_GroupTbl_Deleted]  DEFAULT ((0)) FOR [Deleted]
GO
/****** Object:  StoredProcedure [dbo].[StudyApp_AcceptRequestToJoinUserFromGroup]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Joshua Nishiguchi
-- Create date: 12/15/2019
-- Description:	Accept a user from the group only if the user is owner
-- =============================================
CREATE PROCEDURE [dbo].[StudyApp_AcceptRequestToJoinUserFromGroup]
	@OwnerID bigint,
	@UserID bigint, --User that will be added into the group
	@PostID bigint
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    UPDATE g
	SET Accepted = 1
	FROM GroupTbl g
	INNER JOIN GroupPostTbl gp
	ON
		g.GroupPostID = gp.GroupPostID
	WHERE
		GroupOwnerID = @OwnerID AND --Person claiming to be owner is actually the owner
		g.GroupPostID = @PostID AND
		g.GroupUserID = @UserID AND
		g.Accepted = 0 AND --They're not currently accepted (if they are, then we duplicate action)
		g.Deleted = 0 --And not currently deleted
END
GO
/****** Object:  StoredProcedure [dbo].[StudyApp_FindGroupPosts]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Joshua Nishiguchi
-- Create date: 12/10/2019
-- Description:	Queries for group posts that the user is not currently accepted in
-- =============================================
CREATE PROCEDURE [dbo].[StudyApp_FindGroupPosts]
	@ClassName nvarchar(75),
	@UserID bigint = 0,
	@Monday int = 0,
	@Tuesday int= 0,
	@Wednesday int= 0,
	@Thursday int = 0,
	@Friday int = 0,
	@Saturday int = 0,
	@Sunday int = 0
	
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;


	DECLARE @sql varchar(max)
	DECLARE @app bit = 0
	DECLARE @close bit = 0

	--Dynamic sql to add filteration for days
	SET @sql = 'SELECT gp.GroupPostID, GroupName, ClassName, GroupDescription, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, 
						CASE
							--If accepted is not null, we know that Accepted = 0 since NOT IN filters out 1s
							WHEN g.Accepted IS NOT NULL THEN
								1
							ELSE
								0
						END as Applied
				FROM GroupPostTbl gp
				LEFT JOIN GroupTbl g
				ON
					gp.GroupPostID = g.GroupPostID AND
					--Do these filters in here so we can grab null values
					g.Deleted = 0 AND
					g.GroupUserID = ' + CAST(@UserID AS varchar) + '
				WHERE
					gp.Deleted = 0 AND
					gp.GroupOwnerID <> ' + CAST(@UserID AS varchar) + ' AND
					gp.GroupPostID NOT IN (SELECT p.GroupPostID
										FROM GroupPostTbl p
										INNER JOIN GroupTbl g
										ON
											p.GroupPostID = g.GroupPostID
										WHERE
											p.Deleted = 0 AND
											g.GroupUserID = ' + CAST(@UserID AS varchar) + ' AND
											g.Accepted = 1 AND
											g.Deleted = 0) AND
					ClassName = ''' + @ClassName + ''''
	IF @Monday = 1
	BEGIN
		SET @sql = @sql + ' AND (Monday = 1'
		SET @app = 1
	END

	IF @Tuesday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Tuesday = 1'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Tuesday = 1'
			SET @app = 1
		END
	END

	IF @Wednesday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Wednesday = 1'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Wednesday = 1'
			SET @app = 1
		END
	END

	IF @Thursday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Thursday = 1'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Thursday = 1'
			SET @app = 1
		END
	END

	IF @Friday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Friday = 1'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Friday = 1'
			SET @app = 1
		END
	END

	IF @Saturday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Saturday = 1'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Saturday = 1'
			SET @app = 1
		END
	END

	IF @Sunday = 1
	BEGIN
		IF @app = 1
		BEGIN
			SET @sql = @sql + ' OR Sunday = 1)'
		END
		ELSE
		BEGIN
			SET @sql = @sql + ' AND (Sunday = 1)'
			SET @app = 1
		END
		SET @close = 1
	END

	--If we do apply day filters, make sure to close
	IF @close = 0 AND @app = 1
	BEGIN
		SET @sql = @sql + ')'
	END

	exec(@sql)

END
GO
/****** Object:  StoredProcedure [dbo].[StudyApp_GetMyGroups]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Joshua Nishiguchi
-- Create date: 12/14/2019
-- Description:	Get groups that the user owns and is part of
-- =============================================
CREATE PROCEDURE [dbo].[StudyApp_GetMyGroups]
	@UserID bigint
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	--Get all groups user owns
    SELECT GroupPostID, GroupName, ClassName, GroupDescription, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, 1 as [Owner]
	FROM GroupPostTbl
	WHERE
		GroupOwnerID = @UserID AND
		Deleted = 0
	UNION
	--Groups user has been accepted in
	SELECT gp.GroupPostID, GroupName, ClassName, GroupDescription, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, 0 as [Owner]
	FROM GroupPostTbl gp
	INNER JOIN GroupTbl g
	ON
		gp.GroupPostID = g.GroupPostID AND
		--Owner not the same as groupuser (stops duplicates)
		gp.GroupOwnerID <> g.GroupUserID
	WHERE
		g.Accepted = 1 AND
		g.GroupUserID = @UserID AND
		gp.Deleted = 0 AND
		g.Deleted = 0
	ORDER BY [Owner] DESC, GroupName ASC

END
GO
/****** Object:  StoredProcedure [dbo].[StudyApp_GetUsersFromGroup]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Joshua Nishiguchi
-- Create date: 12/14/2019
-- Description:	Get all users from group
-- =============================================
CREATE PROCEDURE [dbo].[StudyApp_GetUsersFromGroup]
	@GroupPostID bigint,
	@OwnerID bigint
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	--Get all the UIDs and user information from the group post that is not the owner
    SELECT u.id, u.[name], u.email, Accepted
	FROM GroupPostTbl gp
	INNER JOIN GroupTbl g
	ON
		g.GroupPostID = gp.GroupPostID
	INNER JOIN users u
	ON
		u.id = g.GroupUserID
	WHERE
		gp.GroupPostID = @GroupPostID AND
		gp.Deleted = 0 AND
		g.Deleted = 0 AND
		--Dont return the owner as part of his own group
		u.id <> @OwnerID
END
GO
/****** Object:  StoredProcedure [dbo].[StudyApp_RemoveUserFromGroup]    Script Date: 12/15/2019 8:28:15 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Joshua Nishiguchi
-- Create date: 12/15/2019
-- Description:	Remove a user from the group only if the user is owner
-- =============================================
CREATE PROCEDURE [dbo].[StudyApp_RemoveUserFromGroup]
	@OwnerID bigint,
	@UserID bigint, --User that will be removed from the group (soft delete)
	@PostID bigint
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    UPDATE g
	SET Deleted = 1
	FROM GroupTbl g
	INNER JOIN GroupPostTbl gp
	ON
		g.GroupPostID = gp.GroupPostID
	WHERE
		GroupOwnerID = @OwnerID AND --Person claiming to be owner is actually the owner
		g.GroupPostID = @PostID AND
		g.GroupUserID = @UserID AND
		g.Accepted = 1 AND --They're accepted (if they aren't, why delete?)
		g.Deleted = 0 --And not currently deleted
END
GO
USE [master]
GO
ALTER DATABASE [StudyApp] SET  READ_WRITE 
GO
